import Validate from '../partials/validate';
import Control  from '../partials/control';
import AppCore  from '../partials/cores';

const Auth = {
    actionUser(type, callBack) {
        let formIsValid = true;

        let formData = {
            action: type
        };

        $("." + type).each(function() {
            let validator  = new Validate();
            let inputNode  = this;
            let inputType  = inputNode.getAttribute('data-type');
            let inputName  = inputNode.getAttribute('name');
            let inputValue = inputNode.value;
            let required   = validator.hooks.required(inputNode);
            let noErrors   = true;

            if(!required) {
                noErrors = false;
            } else {
                switch (inputType) {
                    case "email":
                        noErrors = validator.hooks.valid_email(inputNode);
                        break;
                    case "phone":
                        noErrors = validator.hooks.mobileNumber(inputNode);
                        break;
                    case "name":
                        noErrors = (validator.hooks.alpha(inputNode));
                        break;
                    case "text":
                        noErrors = (validator.hooks.min_length(inputNode, 3));
                        break;
                    case "password":
                        noErrors = validator.hooks.password(inputNode);
                        break;
                }
            }

            if(!noErrors) {
                inputNode.classList.add('auth-error');
                formIsValid = false;
            } else {
                formData[inputName] = inputValue;
                if(inputNode.classList.contains('auth-error')) {
                    inputNode.classList.remove('auth-error');
                }
            }
        });

        if(formIsValid) {
            Control.poster(formData, function (response) {
                if(response.errors && Object.keys(response.errors).length > 0) {
                    Object.keys(response.errors).map(function(key) {
                        $('#' + type + '_' + key).addClass('auth-error');
                    });
                }

                if(response.messages && Object.keys(response.messages).length > 0) {
                    let messageClass = "auth-message";
                    let messagePlace = $('#auth-info-messages');

                    AppCore.removeXhrMessages(messageClass);

                    Object.keys(response.messages).map(function (key) {
                        let messageBlock = AppCore.createXhrMessages(response.messages[key], messageClass);
                        messagePlace.prepend(messageBlock);
                    });

                    AppCore.scrollToNode(messagePlace);
                }

                if(typeof callBack === 'function') {
                    callBack(response);
                }

                if(response.location) {
                    window.location = response.location;
                }
            });
        } else {
            AppCore.scrollToNode($("." + type + ".auth-error"));
        }
    },

    subscribe() {
        let formData    = {};
        let formIsValid = true;

        $('.subscribe-input').each(function() {
            let inputNode  = this;
            let inputType  = inputNode.getAttribute('data-type');
            let inputName  = inputNode.getAttribute('name');
            let inputValue = inputNode.value;
            let validator  = new Validate();
            let required   = validator.hooks.required(inputNode);
            let noErrors   = true;

            if(!required) {
                noErrors = false;
            } else {
                switch (inputType) {
                    case "email":
                        noErrors = validator.hooks.valid_email(inputNode);
                        break;
                }
            }

            if(!noErrors) {
                inputNode.classList.add('error');
                formIsValid = false;
            } else {
                formData[inputName] = inputValue;
                if(inputNode.classList.contains('error')) {
                    inputNode.classList.remove('error');
                }
            }
        });

        if(formIsValid) {
            formData["action"] = "subscribe";
            Control.poster(formData, function (response) {
                if(response.errors && Object.keys(response.errors).length > 0) {
                    Object.keys(response.errors).map(function(key) {
                        $('#' + key).addClass('error');
                    });
                }

                let messageClass = "subscribe-message";
                let messagePlace = $('#subscribe-messages');

                Object.keys(response.messages).map(function (key) {
                    AppCore.removeXhrMessages(messageClass);
                    let messageBlock = AppCore.createXhrMessages(response.messages[key], messageClass);
                    messagePlace.prepend(messageBlock);
                });

                AppCore.scrollToNode(messagePlace);
            });
        } else {
            AppCore.scrollToNode($('.subscribe-input.error'));
        }
    },

    goToLocation(link) {
        let hostSep  = "//";
        let homeUrl  = location.protocol + hostSep + location.host;
        let locateTo = link || "";
        document.location.href = homeUrl + locateTo;
    }
};

module.exports = Auth;