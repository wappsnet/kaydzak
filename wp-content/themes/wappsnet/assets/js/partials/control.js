const Control = {
    ajaxUrl: window.location.origin + '/wp-admin/admin-ajax.php',

    poster: function(data, successCallback, failCallback) {
        data = $.param(data);

        $.post(this.ajaxUrl, data, function (response) {
            if (response) {
                let responseData = response;
                try {
                    responseData = JSON.parse(response);
                } catch (e) {

                }
                successCallback(responseData);
            } else {
                if (typeof failCallback === 'function') {
                    failCallback(response);
                } else {
                    Materialize.toast('Server Error!', 5000);
                }
            }
        });
    },

    uploader: function(data, successCallback, failCallback) {
        $.ajax({
            method:       "POST",
            url:          this.ajaxUrl,
            dataType:     "json",
            contentType:  false,
            processData:  false,
            data:         data,

            success: function(response) {
                try {
                    successCallback(JSON.parse(response));
                } catch(e) {
                    successCallback(response);
                }
            },

            error: function(response) {
                failCallback(response);
            }
        });
    },

    request: function(data, successCallback, failCallback) {
        $.ajax({
            method:      'POST',
            url:         this.ajaxUrl,
            dataType:    'html',
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            data:        data,

            success: function(response) {
                try {
                    successCallback(JSON.parse(response));
                } catch(e) {
                    successCallback(response);
                }
            },

            error: function(response) {
                try {
                    failCallback(JSON.parse(response));
                } catch(e) {
                    failCallback(response);
                }
            }
        });
    }
};

module.exports = Control;
