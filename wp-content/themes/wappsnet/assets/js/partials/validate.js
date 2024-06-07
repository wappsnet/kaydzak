function  Validate() {
    var _self = this;
    this.rules = {
        ruleRegex: /^(.+?)\[(.+)\]$/,
        numericRegex: /^[0-9]+$/,
        mobileNumberRegex: /^([+()0-9-\s\.]{0,20})$/i,
        integerRegex: /^\-?[0-9]+$/,
        decimalRegex: /^\-?[0-9]*\.?[0-9]+$/,
        emailRegex: /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
        alphaRegex: /^[a-zа-я]+$/i,
        alphaNumericRegex: /^[a-zа-я0-9]+$/i,
        alphaDashRegex: /^[a-zа-я0-9_\-]+$/i,
        naturalRegex: /^[0-9]+$/i,
        naturalNoZeroRegex: /^[1-9][0-9]*$/i,
        ipRegex: /^((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){3}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})$/i,
        base64Regex: /[^a-zA-Z0-9\/\+=]/i,
        numericDashRegex: /^[\d\-\s]+$/,
        urlRegex: /^((http|https):\/\/(\w+:{0,1}\w*@)?(\S+)|)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?$/,
        dateRegex: /\d{4}-\d{1,2}-\d{1,2}/,
        dateTimeRegex: /\d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+([+-][0-2]\d:[0-5]\d|Z)/,
        timeRegex: /([01]\d|2[0-3]):([0-5]\d)/
    };

    this.hooks = {
        getValidDate: function (date) {
            if (!date.match('today') && !date.match(this.dateRegex)) {
                return false;
            }

            let validDate = new Date(),
                validDateArray;

            if (!date.match('today')) {
                validDateArray = date.split('-');
                validDate.setFullYear(validDateArray[0]);
                validDate.setMonth(validDateArray[1] - 1);
                validDate.setDate(validDateArray[2]);
            }
            return validDate;
        },

        required: function (field) {
            return (field.value !== null && field.value !== '');
        },

        defaultField: function (field, defaultName) {
            return field.value !== defaultName;
        },

        matches: function (field, matchName) {
            let el = _self.GetElementInsideContainer(matchName);
            if (el) {
                return field.value === el.value;
            }
            return false;
        },

        mobileNumber: function (field) {
            return _self.rules.mobileNumberRegex.test(field.value);
        },

        valid_email: function (field) {
            return _self.rules.emailRegex.test(field.value);
        },

        valid_emails: function (field) {
            let result = field.value.split(/\s*,\s*/g);
            for (let i = 0, resultLength = result.length; i < resultLength; i++) {
                if (!_self.rules.emailRegex.test(result[i])) {
                    return false;
                }
            }
            return true;
        },

        password: function(field) {
            if (!_self.hooks.alpha_numeric(field.value)) {
                return false;
            }
            return (field.value.length >= parseInt(2, 10));
        },

        min_length: function (field, length) {
            return (field.value.length >= parseInt(length, 10));
        },

        max_length: function (field, length) {
            return (field.value.length <= parseInt(length, 10));
        },

        exact_length: function (field, length) {
            return (field.value.length === parseInt(length, 10));
        },

        greater_than: function (field, param) {
            if (!_self.rules.decimalRegex.test(field.value)) {
                return false;
            }
            return (parseFloat(field.value) > parseFloat(param));
        },

        less_than: function (field, param) {
            if (!_self.rules.decimalRegex.test(field.value)) {
                return false;
            }
            return (parseFloat(field.value) < parseFloat(param));
        },

        alpha: function (field) {
            return (_self.rules.alphaRegex.test(field.value));
        },

        alpha_numeric: function (field) {
            return (_self.rules.alphaNumericRegex.test(field.value));
        },

        alpha_dash: function (field) {
            return (_self.rules.alphaDashRegex.test(field.value));
        },

        text_area: function (field) {
            return (field.value.length > 0);
        },

        numeric: function (field) {
            return (_self.rules.numericRegex.test(field.value));
        },

        integer: function (field) {
            return (_self.rules.integerRegex.test(field.value));
        },

        decimal: function (field) {
            return (_self.rules.decimalRegex.test(field.value));
        },

        is_natural: function (field) {
            return (_self.rules.naturalRegex.test(field.value));
        },

        is_natural_no_zero: function (field) {
            return (_self.rules.naturalNoZeroRegex.test(field.value));
        },

        valid_ip: function (field) {
            return (_self.rules.ipRegex.test(field.value));
        },

        valid_base64: function (field) {
            return (_self.rules.base64Regex.test(field.value));
        },

        valid_url: function (field) {
            return (_self.rules.urlRegex.test(field.value));
        },

        valid_credit_card: function (field) {
            if (!_self.rules.numericDashRegex.test(field.value)) return false;
            var nCheck = 0, nDigit = 0, bEven = false;
            var strippedField = field.value.replace(/\D/g, "");
            for (var n = strippedField.length - 1; n >= 0; n--) {
                var cDigit = strippedField.charAt(n);
                nDigit = parseInt(cDigit, 10);
                if (bEven) {
                    if ((nDigit *= 2) > 9) nDigit -= 9;
                }
                nCheck += nDigit;
                bEven = !bEven;
            }
            return (nCheck % 10) === 0;
        },

        is_file_type: function (field, type) {
            if (field.type !== 'file') {
                return true;
            }
            var ext = field.value.substr((field.value.lastIndexOf('.') + 1)),
                typeArray = type.split(','),
                inArray = false,
                i = 0,
                len = typeArray.length;
            for (i; i < len; i++) {
                if (ext == typeArray[i]) inArray = true;
            }
            return inArray;
        },

        greater_than_date: function (field, date) {
            var enteredDate = this.getValidDate(field.value),
                validDate = this.getValidDate(date);
            if (!validDate || !enteredDate) {
                return false;
            }
            return enteredDate > validDate;
        },

        less_than_date: function (field, date) {
            var enteredDate = this.getValidDate(field.value),
                validDate = this.getValidDate(date);

            if (!validDate || !enteredDate) {
                return false;
            }
            return enteredDate < validDate;
        },

        greater_than_or_equal_date: function (field, date) {
            var enteredDate = this.getValidDate(field.value),
                validDate = this.getValidDate(date);
            if (!validDate || !enteredDate) {
                return false;
            }
            return enteredDate >= validDate;
        },

        less_than_or_equal_date: function (field, date) {
            var enteredDate = this.getValidDate(field.value),
                validDate = this.getValidDate(date);

            if (!validDate || !enteredDate) {
                return false;
            }
            return enteredDate <= validDate;
        },

        existing_email: function() {
            return _self.messages['am']['existing_email'];
        },

        existing_mobile: function() {
            return _self.messages['am']['existing_mobile'];
        }
    };
}

export default Validate;