let Ajax = {
    rest: function( args, callbackResponse ) {

        this.send( window.location.origin + '/inc/rest/' + args.action, args, callbackResponse );
    },

    send: function( url, args, callbackResponse ) {
        let formData = new FormData();
        formData.append( '_nonce', 1 );

        for ( let key in args ) {
            formData.append( key, args[key] );
        }
        fetch( url, {
            method: 'POST',
            body: formData,
        } ).then( function( response ) {
            response.json().then( function( result ) {
                if ( callbackResponse ) {
                    callbackResponse( result );
                }
            } );
        } );

    },
};

let TestMillenium = {

    user_id: '',

    getUserId: function() {
        var url = new URL(window.location.href);
        if ( url.searchParams.has("user_id") ) {
            this.user_id = url.searchParams.get("user_id");
        } else {
            this.user_id = false;
        }
    },

    getUsers: function() {
        this.getUserId();
        var self = this;
        this.send( {
            'action': 'get-users.php',
            'user_id': self.user_id,
        }, function( result ) {
            var options = '';
            if ( self.user_id ) {
                options = '<option value="">Выберите пользователя</option>';
            } else {
                options = '<option value="" selected>Выберите пользователя</option>';
            }
            for (i in result) {
                var selected = '';
                if ( result[i].id == self.user_id ) {
                    selected = 'selected';
                }
                options += '<option value="' + result[i].id + '" ' + selected + '>' + result[i].name + '</option>';
            }
            document.querySelector( '#users-select-get' ).innerHTML = options;
            document.querySelector( '#users-select-ajax' ).innerHTML = options;
        });
    },

    getProducts: function() {
        this.send( {
            'action': 'get-products.php',
        }, function( result ) {
            var input = document.createElement('select');
            input.classList.add('form-control');
            input.classList.add('mb-3');
            input.name = 'product_ids[]';
            input.innerHTML = '<option value="">Выберите товар</option>';
            for (i in result) {
                input.innerHTML += '<option value="' + result[i].id + '">' + result[i].title + ' (' + result[i].price + ')</option>';
            }
            document.querySelector( '#products_input' ).appendChild(input);
        });
    },

    saveOrder: function(e) {
        this.send( {
            'action': 'save-orders.php',
            'user_id': e.get('user_id'),
            'product_ids': e.getAll('product_ids[]'),
        }, function( result ) {
            if(result) {
                var url = new URL(window.location.origin);
                url.searchParams.set("user_id", result);
                window.location.href = url;
            }
        });
    },

    getUser: function(e) {
        var url = new URL(window.location.href);
        if (e.value) {
            url.searchParams.set("user_id", e.value);

        } else {
            url.searchParams.delete("user_id");
        }
        window.location.href = url;
    },

    getOrdersGet: function() {
        this.getUserId();
        var self = this;
        if (self.user_id) {
            this.send({
                'action': 'get-orders.php',
                'user_id': self.user_id,
            }, function (result) {
                if (result) {
                    self.drawTable(result);
                }
            });
        } else {
            document.querySelector( '#user_orders' ).style.display = 'none';
            document.querySelector( '#user_name' ).innerHTML = '';
        }
    },

    getOrdersAjax: function(e) {
        this.user_id = e.value;
        var self = this;
        if (self.user_id) {
            this.send({
                'action': 'get-orders.php',
                'user_id': self.user_id,
            }, function (result) {
                if (result) {
                    self.drawTable(result);
                }
            });
        } else {
            document.querySelector( '#user_orders' ).style.display = 'none';
            document.querySelector( '#user_name' ).innerHTML = '';
        }
    },

    drawTable: function (data) {

        document.querySelector( '#user_name' ).innerHTML = data.user.name;
        var content = '';
        for (i in data.orders) {
            content += '<tr><td>' + data.orders[i].title + '</td><td>' + data.orders[i].price  + '</td></tr>';
        }

        document.querySelector( '#user_orders tbody' ).innerHTML = content;
        document.querySelector( '#user_orders' ).style.display = 'table';

    },
    send: function( data, callback ) {
        Ajax.rest( data, function( result ) {
            callback( result );
        } );
    },
};