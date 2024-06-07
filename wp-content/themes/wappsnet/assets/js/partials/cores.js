const AppCore = {
    Random: {
        used: [],
        possible: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz",

        make: function(length){
            length = length || 5;
            let randomString = "";
            for(let i=0; i<length; i++){
                randomString += AppCore.Random.possible.charAt(Math.floor(Math.random() * AppCore.Random.possible.length));
            }
            if(AppCore.Random.possible.indexOf(randomString) === -1) {
                AppCore.Random.used.push(randomString);
                return randomString;
            } else {
                return (AppCore.Random.make());
            }
        },

        int: function(min, max){
            return Math.floor(Math.random() * (max - min + 1)) + min;
        },
        float:function(min, max){
            return Math.random() * (max - min) + min;
        }
    },

    createScript: function(src, htmlId, removeIfExist, options) {
        if(removeIfExist) {
            let oldScript = document.getElementById(htmlId);
            oldScript.parentNode.removeChild(oldScript);
        }

        let script  = document.createElement('script');
        script.src  = src;
        if(htmlId) {
            script.id = htmlId;
        }

        if(options !== undefined && options.onLoad !== undefined) {
            script.onload = function() {
                AppCore.executeFunctionByName(options.onLoad, window);
            }
        }

        script.type  = "text/javascript";
        document.getElementsByTagName('head')[0].appendChild(script);
    },

    cloneObject: function(object) {
        if(Array.isArray(object)) {
            return Object.assign([], object);
        } else if (typeof object === 'object'){
            return Object.assign({}, object);
        } else{
            return object;
        }
    },

    executeFunctionByName: function(functionName, context /*, args */) {
        let args = [].slice.call(arguments).splice(2);
        let namespaces = functionName.split(".");
        let func = namespaces.pop();
        let len = namespaces.length;
        for(let i = 0; i < len; i++) {
            context = context[namespaces[i]];
        }
        return context[func].apply(context, args);
    },

    findFunctionFromDom: function(functionName, context) {
        let namespaces = functionName.split(".");
        let func = namespaces.pop();
        let len = namespaces.length;
        for(let i = 0; i < len; i++) {
            context = context[namespaces[i]];
        }
        return context[func];
    },

    /*
     * remove value from array by value
     * @arr - array
     * @val value
     * */
    removeFromArrayByValue: function(arr, val){
        let index = arr.indexOf(val);
        if(index > -1) {
            arr.splice(index, 1);
        }
    },

    createNumbersArray: function(min, max, step) {
        let newArray = [];
        let len = max + 1;
        for(let i = min; i < len; i = i + step) {
            newArray.push(i);
        }
        return newArray;
    },

    getKeyByValue: function(object, value, objectKey) {
        for(let key in object) {
            if(typeof objectKey == "undefined") {
                if (object[key] == value) {
                    return key;
                }
            } else {
                if(object[key][objectKey] == value) {
                    return key;
                }
            }
        }
        return false;
    },

    createArrayByLength: function(length) {
        return Array.apply(null, {length: length}).map(Number.call, Number)
    },

    getAverageRGB: function(imgEl) {
        let blockSize = 5, // only visit every 5 pixels
            defaultRGB = {r:0,g:0,b:0}, // for non-supporting envs
            canvas = document.createElement('canvas');
        let context = canvas.getContext && canvas.getContext('2d');

        let data, width, height, length,
            i = -4,
            rgb = {r:0,g:0,b:0},
            count = 0;

        if (!context) {
            return defaultRGB;
        }

        height  = canvas.height = imgEl.naturalHeight || imgEl.offsetHeight || imgEl.height;
        width   = canvas.width  = imgEl.naturalWidth  || imgEl.offsetWidth  || imgEl.width;

        context.drawImage(imgEl.embed, 0, 0);

        try {
            data = context.getImageData(0, 0, width, height);
        } catch(e) {
            /* security error, img on diff domain */
            return defaultRGB;
        }

        length = data.data.length;

        while ( (i += blockSize * 4) < length ) {
            ++count;
            rgb.r += data.data[i];
            rgb.g += data.data[i+1];
            rgb.b += data.data[i+2];
        }

        // ~~ used to floor values
        rgb.r = ~~(rgb.r/count);
        rgb.g = ~~(rgb.g/count);
        rgb.b = ~~(rgb.b/count);
        return rgb;
    },

    getAbsolutePos: function (element, all) {
        let position = element.getBoundingClientRect();
        if(typeof all === 'undefined' || !all) {
            return {
                x: position.left,
                y: position.top
            }
        } else {
            return position;
        }
    },

    getPosition: function(el) {
        let xPos = 0,
            yPos = 0,
            width = el.offsetWidth,
            height = el.offsetHeight,
            parentCount = 0,
            points = {},
            element = el;

        while (el) {
            if (el.tagName == "BODY") {
                // deal with browser quirks with body/window/document and page scroll
                let xScroll = el.scrollLeft || document.documentElement.scrollLeft;
                let yScroll = el.scrollTop  || document.documentElement.scrollTop;

                xPos += (el.offsetLeft - xScroll + el.clientLeft);
                yPos += (el.offsetTop  - yScroll + el.clientTop);
            } else {
                // for all other non-BODY elements
                xPos += (el.offsetLeft - el.scrollLeft + el.clientLeft);
                yPos += (el.offsetTop - el.scrollTop + el.clientTop);
            }

            parentCount += 1;
            if(parentCount >= 2) {
                break;
            }
            el = el.offsetParent;
        }


        //if hierarchical structure is very large count with clientRect
        if(parentCount >= 2) {
            points = AppCore.getAbsolutePos(element, true);
        } else {
            let documentWidth = document.body.offsetWidth,
                documentHeight = document.body.offsetHeight;
            let right = documentWidth - xPos,
                bottom = documentHeight - yPos;

            points = {
                left: xPos,
                top: yPos,
                right: right,
                bottom: bottom,
                width: width,
                height: height
            };
        }

        return (points);
    },

    circularMotionByNode: function(fromElem, toElem, options) {
        let fromPosition = AppCore.getAbsolutePos(fromElem);
        let toPosition   = AppCore.getAbsolutePos(toElem);

        AppCore.circularMotionByPos(fromPosition, toPosition, options);
    },

    /**
     * curvilinear motion iteration
     * @param fromPosition - pos from where motion start
     * @param toPosition - pos on which motion end
     * @param options - object {
     * count: "iterations count",
      * delay: "animation delay in ms",
      * variation: "middlePos variation 0-2",
      * className: motion element class
      * image: motion element image
      * }
     */
    circularMotionByPos: function(fromPosition, toPosition, options) {
        //motion options
        let counter      = 0;
        let itCount      = options.count || 100;
        let increase     = 1/itCount;
        let delay        = options.delay || 500;
        let interval     = delay/itCount;
        let scaleAble    = options.scaleAble || "disable";
        let blinkAble    = options.blinkAble || "enable";
        let variationX   = options.variationX || 1;
        let variationY   = options.variationY || 0.5;

        //calculate 3 points coordinates
        let distanceToX    = toPosition.x - fromPosition.x;
        let distanceToY    = toPosition.y - fromPosition.y;
        let middlePosX     = fromPosition.x + distanceToX * variationX;
        let middlePosY     = fromPosition.y + distanceToY * variationY;
        let middlePosition = {x:middlePosX, y:middlePosY};

        let newElement = undefined;
        if(options.element === undefined) {
            //create motioning element
            newElement = document.createElement("div");
            newElement.style.top = fromPosition.y + "px";
            newElement.style.left = fromPosition.x + "px";
            newElement.classList.add("motion-element");
            newElement.classList.add("g-bright150");
        } else {
            newElement = options.element;
        }

        if(options.hasOwnProperty("className")) {
            options.className.map(function(value) {
                newElement.classList.add(value);
            });
        }

        if(options.hasOwnProperty("image")) {
            newElement.style.backgroundImage = "url(" + options.image + ")";
            newElement.classList.add("motion-image");
        }

        if(options.hasOwnProperty("icon")) {
            newElement.innerHTML = '<i class="fa fa-' + options.icon + '"></i>';
        }

        document.body.appendChild(newElement);


        if(options.hasOwnProperty("content")) {
            newElement.appendChild(options.content);
        }

        let newOptions = {
            itCount:    itCount,
            increase:   increase,
            delay:      delay,
            interval:   interval,
            scaleAble:  scaleAble,
            blinkAble:  blinkAble,
            endNode:    options.endNode,
            variationX: variationX,
            variationY: variationY
        };

        let newPositions = {
            x1: fromPosition.x,
            y1: fromPosition.y,
            x2: middlePosition.x,
            y2: middlePosition.y,
            x3: toPosition.x,
            y3: toPosition.y
        };

        this.motionIterator(newElement, newOptions, counter, newPositions);
    },

    motionIterator: function(newElement, options, counter, positions) {
        let intervalTimer = setInterval(function() {
            if(counter >= 1) {
                newElement.classList.add("motion-hide");

                if(options.endNode !== undefined) {
                    options.endNode.classList.add("primary-z");
                    if(options.blinkAble == "enable") {
                        AppCore.animate(options.endNode, 1, 70, "blinkBright");
                    }
                }

                setTimeout(function() {
                    if(options.endNode !== undefined) {
                        options.endNode.classList.remove("primary-z");
                    }

                    if(newElement && newElement.parentNode) {
                        newElement.parentNode.removeChild(newElement);
                    }
                }, 300);

                clearInterval(intervalTimer);
            }

            counter += options.increase;

            let newX = Math.pow((1 - counter), 2) * positions.x1  + 2 * (1 - counter) * counter * positions.x2 + Math.pow(counter, 2) * positions.x3;
            let newY = Math.pow((1 - counter), 2) * positions.y1  + 2 * (1 - counter) * counter * positions.y2 + Math.pow(counter, 2) * positions.y3;

            newElement.style.left = newX + "px";
            newElement.style.top = newY + "px";

            if(options.scaleAble == "enable" && counter >= 0.5) {

                let distanceToX = positions.x3 - newX;
                let distanceToY = positions.y3 - newY;
                let middlePosX  = newX + distanceToX * options.variationX;
                let middlePosY  = newY + distanceToY * options.variationY;

                let newPositions = {
                    x1: newX,
                    y1: newY,
                    x2: middlePosX,
                    y2: middlePosY,
                    x3: positions.x3,
                    y3: positions.y3
                };

                let newOptions = options;
                newOptions.scaleAble = false;
                newOptions.interval  = options.interval/2;

                setTimeout(function() {
                    AppCore.motionIterator(newElement, newOptions, counter, newPositions);
                }, 100);

                AppCore.animate(newElement, 1, 300, "blinkBright");
                clearInterval(intervalTimer);
            }
        }, options.interval);
    },

    animate: function(element, count, duration, name) {
        let animationElement = element;
        let animateDuration  = count*duration;
        animationElement.style.animationName = name;
        animationElement.style.animationDuration = duration + "ms";
        animationElement.style.animationIterationCount = count;

        setTimeout(function() {
            animationElement.style.animationName = null;
            animationElement.style.animationDuration = null;
            animationElement.style.animationIterationCount = null;
        }, animateDuration);
    },


    filterByLatCyr: function (string, from, to) {
        let language = {
            ru: ['а','б','в','г','д','e','ж','з','и','й','к','л','м',
                'н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ',
                'ъ','ь','ю','я','А','Б','В','Г','Д','Е','Ж','З','И',
                'Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х',
                'Ц','Ч','Ш','Щ','Ъ','Ь', 'Ю','Я'],

            us: ['a','b','v','g','d','e','zh','z','i','y','k','l','m',
                'n','o','p','r','s','t','u','f','h','ts','ch','sh',
                'sht','a','y','yu','ya','A','B','V','G','D','E','Zh',
                'Z','I','Y','K','L','M','N','O','P','R','S','T','U',
                'F' ,'H' ,'Ts','Ch','Sh','Sht','A','Y','Yu','Ya']
        };

        let search = string;

        for(let i = 0; i < language[from].length; i++) {
            search = search.replace(new RegExp(language[from][i],"g"), language[to][i]);
        }



      return search;
    },

    addListener: function (eventType, eventFunction, node) {
        let nodeElement = node || document;
        if(nodeElement.addEventListener) {
            nodeElement.addEventListener(eventType, eventFunction);
        } else {
            nodeElement.attachEvent(eventType, eventFunction);
        }
    },

    deleteListener: function(eventType, eventFunction, node) {
        let nodeElement = node || document;
        nodeElement.removeEventListener(eventType, eventFunction);
    },

    removeXhrMessages: function (className) {
        let existMessages = document.getElementsByClassName(className);

        for (let i = 0; i < existMessages.length; i++) {
            existMessages[i].parentNode.removeChild(existMessages[i]);
        }
    },

    createXhrMessages: function (message, className, error) {
        let messageBlock = document.createElement('div');
        messageBlock.classList.add(className);

        if(error) {
            messageBlock.classList.add(error);
        }

        messageBlock.innerHTML = message;
        return messageBlock;
    },

    scrollToNode: function(scrollNode) {
        let scrollPoint = scrollNode.offset().top - 70;
        $('html, body').animate({scrollTop: scrollPoint}, 300)
    }
};

export default AppCore;
