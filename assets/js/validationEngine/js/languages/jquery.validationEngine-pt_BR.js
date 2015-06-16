(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {

                /* MASKS VALIDATIONS */

                "phone": {
                    "regex": /\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}/g,
                    "alertText": "* Telefone inválido"
                },

                "phone-us": {
                    "regex": /\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}/g,
                    "alertText": "* Telefone inválido"
                },

                "cpf": {
                    // CPF is the Brazilian ID
                    "func" : function(field, rules, i, options){
                        cpf = field.val().replace(/[^0-9]+/g, '');
                        while(cpf.length < 11) cpf = "0"+ cpf;

                        var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
                        var a = cpf.split('');
                        var b = new Number;
                        var c = 11;
                        b += (a[9] * --c);
                        if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
                        b = 0;
                        c = 11;
                        for (y=0; y<10; y++) b += (a[y] * c--);
                        if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

                        var error = false;
                        if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) error = true;
                        return !error;
                    },
                    "alertText": "* CPF inválido",
                    "alertTextOK": "* CPF válido"
                },

                "cnpj": {
                    "func" : function (field, rules, i, options) {

                        cnpj = field.val().replace(/[^\d]+/g,'');

                        if (cnpj == '') return false;

                        if (cnpj.length != 14)
                            return false;

                        // Elimina CNPJs invalidos conhecidos
                        if (cnpj == "00000000000000" ||
                            cnpj == "11111111111111" ||
                            cnpj == "22222222222222" ||
                            cnpj == "33333333333333" ||
                            cnpj == "44444444444444" ||
                            cnpj == "55555555555555" ||
                            cnpj == "66666666666666" ||
                            cnpj == "77777777777777" ||
                            cnpj == "88888888888888" ||
                            cnpj == "99999999999999")
                            return false;

                        // Valida DVs
                        tamanho = cnpj.length - 2
                        numeros = cnpj.substring(0,tamanho);
                        digitos = cnpj.substring(tamanho);
                        soma = 0;
                        pos = tamanho - 7;
                        for (i = tamanho; i >= 1; i--) {
                          soma += numeros.charAt(tamanho - i) * pos--;
                          if (pos < 2)
                                pos = 9;
                        }
                        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                        if (resultado != digitos.charAt(0))
                            return false;

                        tamanho = tamanho + 1;
                        numeros = cnpj.substring(0,tamanho);
                        soma = 0;
                        pos = tamanho - 7;
                        for (i = tamanho; i >= 1; i--) {
                          soma += numeros.charAt(tamanho - i) * pos--;
                          if (pos < 2)
                                pos = 9;
                        }
                        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                        if (resultado != digitos.charAt(1))
                              return false;

                        return true;

                    },
                    "alertText": "* CNPJ Inválido",
                    "alertTextOK": "* CNPJ válido"
                },

                "date" : {
                    //  Check if date is valid by leap year
                    "func": function (field) {
                       var pattern = new RegExp(/^(\d{4})[\/\-\.](0?[1-9]|1[012])[\/\-\.](0?[1-9]|[12][0-9]|3[01])$/);
                       var match = pattern.exec(field.val());
                       if (match == null)
                           return false;

                       var year = match[1];
                       var month = match[2]*1;
                       var day = match[3]*1;
                       var date = new Date(year, month - 1, day); // because months starts from 0.

                       return (date.getFullYear() == year && date.getMonth() == (month - 1) && date.getDate() == day);
                    },
                    "alertText": "* Data inválida, deve estar no formato YYYY-MM-DD"
                },

                "date-us": {
                    //  Check if date is valid by leap year
                    "func" : function (field) {
                       var pattern = new RegExp(/^(0?[1-9]|1[012])[\/\-\.](0?[1-9]|[12][0-9]|3[01])[\/\-\.](\d{4})$/);
                       var match = pattern.exec(field.val());
                       if (match == null)
                           return false;

                       var year = match[3];
                       var month = match[1]*1;
                       var day = match[2]*1;
                       var date = new Date(year, month - 1, day); // because months starts from 0.

                       return (date.getFullYear() == year && date.getMonth() == (month - 1) && date.getDate() == day);
                    },
                    "alertText": "* Data inválida, deve estar no formato MM/DD/YYYY"
                },

                "cep": {
                    "regex": /^[0-9]{2}[0-9]{3}-[0-9]{3}$/,
                    "alertText": "* CEP inválido"
                },

                "time": {
                    "regex": /^[0-9]{1}[0-9]{1}:[0-9]{1}[0-9]{1}$/,
                    "alertText": "* Tempo inválido"
                },

                "hour": {
                    "regex": /^[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}$/,
                    "alertText": "* Hora inválida"
                },

                "credit-card": {
                    "regex": /^[0-9]{4}\s[0-9]{4}\s[0-9]{4}\s[0-9]{4}$/,
                    "alertText": "* Cartão de crédito inválido"
                },

                "integer": {
                    "regex": /^[\-\+]?\d+$/,
                    "alertText": "* Número inteiro inválido"
                },

                "decimal": {
                    "regex": /^-?\d*(\.\d+)?$/,
                    "alertText": "* Número decimal/float inválido"
                },

                /* OTHER VALIDATIONS */

                "required": {
                    "regex": "none",
                    "alertText": "* Este campo é obrigatório",
                    "alertTextCheckboxMultiple": "* Selecione uma opcão",
                    "alertTextCheckboxe": "* Checkbox obrigatório",
                    "alertTextDateRange": "* Ambas datas são obrigatórias"
                },

                "dateRange": {
                    "regex": "none",
                    "alertText": "* Intervalo de datas ",
                    "alertText2": "inválido"
                },

                "dateTimeRange": {
                    "regex": "none",
                    "alertText": "* Intervalo de data/hora ",
                    "alertText2": "inválido"
                },

                "minSize": {
                    "regex": "none",
                    "alertText": "* Mínimo ",
                    "alertText2": " caracteres obrigatórios"
                },

                "maxSize": {
                    "regex": "none",
                    "alertText": "* Máximo ",
                    "alertText2": " caracteres permitidos"
                },

                "groupRequired": {
                    "regex": "none",
                    "alertText": "* Preencha uma das opcões",
                    "alertTextCheckboxMultiple": "* Selecione uma opcão",
                    "alertTextCheckboxe": "* Checkbox obrigatório"
                },

                "min": {
                    "regex": "none",
                    "alertText": "* Valor mínimo é "
                },

                "max": {
                    "regex": "none",
                    "alertText": "* Valor máximo é "
                },

                "past": {
                    "regex": "none",
                    "alertText": "* Data até "
                },

                "future": {
                    "regex": "none",
                    "alertText": "* Data até "
                },

                "maxCheckbox": {
                    "regex": "none",
                    "alertText": "* Máximo ",
                    "alertText2": " opcões permitidas"
                },

                "minCheckbox": {
                    "regex": "none",
                    "alertText": "* Selecione ",
                    "alertText2": " opcões"
                },

                "equals": {
                    "regex": "none",
                    "alertText": "* Campos não são iguais"
                },

                "email": {
                    // HTML5 compatible email regex ( http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#    e-mail-state-%28type=email%29 )
                    "regex": /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
                    "alertText": "* Email inválido"
                },

                "fullname": {
                    "regex":/^([a-zA-Z]+[\'\,\.\-]?[a-zA-Z ]*)+[ ]([a-zA-Z]+[\'\,\.\-]?[a-zA-Z ]+)+$/,
                    "alertText":"* Nome e sobrenome"
                },

                "zip": {
                    "regex":/^\d{5}$|^\d{5}-\d{4}$/,
                    "alertText":"* ZIP inválido"
                },

                "ipv4": {
                    "regex": /^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/,
                    "alertText": "* Endereco IP inválido"
                },

                "url": {
                    "regex": /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i,
                    "alertText": "* URL inválida"
                },

                "onlyNumberSp": {
                    "regex": /^[0-9\ ]+$/,
                    "alertText": "* Apenas números"
                },

                "onlyLetterSp": {
                    "regex": /^[a-zA-Z\ \']+$/,
                    "alertText": "* Apenas letras"
                },

				"onlyLetterAccentSp":{
                    "regex": /^[a-z\u00C0-\u017F\ ]+$/i,
                    "alertText": "* Apenas letras (acentos permitidos)"
                },

                "onlyLetterNumber": {
                    "regex": /^[0-9a-zA-Z]+$/,
                    "alertText": "* Caracteres especiais não permitidos"
                },

                "ajaxUserCall": {
                    "url": "ajaxValidateFieldUser",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    "alertText": "* This user is already taken",
                    "alertTextLoad": "* Validating, please wait"
                },

				"ajaxUserCallPhp": {
                    "url": "phpajax/ajaxValidateFieldUser.php",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* This username is available",
                    "alertText": "* This user is already taken",
                    "alertTextLoad": "* Validating, please wait"
                },

                "ajaxNameCall": {
                    // remote json service location
                    "url": "ajaxValidateFieldName",
                    // error
                    "alertText": "* This name is already taken",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* This name is available",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },

				"ajaxNameCallPhp": {
                    // remote json service location
                    "url": "phpajax/ajaxValidateFieldName.php",
                    // error
                    "alertText": "* This name is already taken",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },

                "className": {
                    "regex": /^[a-zA-Z_]+[a-zA-Z0-9_]*$/,
                    "alertText": "* Nome de classe inválido"
                },

            };
        }
    };

    $.validationEngineLanguage.newLang();

})(jQuery);

// ===========================
// Custom validation for email
// ===========================
var validate_email = function(field, rules, i, options) {

    var exist = false;

    $.ajax({

        url: $('#URL_ROOT').val() + '/app-user/check-email/',
        context: document.body,
        cache: false,
        async: false,
        data: { 'email' : field.val() },
        type: 'POST',
        success: function(data){

            json = $.parseJSON(data);

            if(json.return == true)
                exist = true;
        }
    });

    if( exist )
        return "* Email já utilizado";
}
