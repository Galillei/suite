document.addEventListener('DOMContentLoaded', function(){
    var forms = document.getElementsByClassName('form-validated');

    for (var i = 0; i < forms.length; i++)
    {
        addValidationListeners(forms[i]);
    }
});

function addValidationListeners(form)
{
    var validatedElements = form.getElementsByClassName('validate');
    var submitClass = 'submit';

    for (var i = 0, length = validatedElements.length; i <length; i++ )
    {
        var isSubmit = hasClass(validatedElements[i], 'submit')

        if (isSubmit)
        {
            attachValidator(validatedElements[i], form);
        }


    }
}

function hasClass(element, klass)
{
    return (element.className.split(' ').indexOf(klass) != -1);
}

function attachValidator(element, form)
{
    element.addEventListener('click', function(event){

        validator.removeErrorsFromPreviousValidation();

        var errors = validator.validate(form);

        if (0 < errors.length)
        {
            validator.renderErrorMessages(errors);
            event.stopPropagation();
            event.preventDefault();
        }

    })
}

validator = {
    validationRules: {
        'checked': function(element){
            if(!element.checked)
            {
                return 'Checkbox is not checked';
            }

            return false;
        },
        'email': function(element){
            if (element.value.indexOf('@') == -1)
            {
                return 'Email is not valid';
            }
        },
        'max-length': function(element){
            if(element.value.length > 255)
            {
                return 'String is too long';
            }
        }
    },

    renderedErrorBlocks : [],

    validate: function(form)
    {
        var validatedElements = form.getElementsByClassName('validate');
        var formValidationErrors = new Array(), elementValidationErrors, element;

        for(var i in validatedElements)
        {
            if (validatedElements.hasOwnProperty(i))
            {
                element = validatedElements[i];
                elementValidationErrors = this.validateElement(element);

                if (elementValidationErrors)
                {
                    formValidationErrors.push({'element' : element, 'errors': elementValidationErrors});
                }
            }
        }

        return formValidationErrors;
    },

    validateElement: function(element)
    {
        var error;
        var elementErrors = new Array();

        for (var key in this.validationRules)
        {
            if (hasClass(element, key))
            {
                error = this.validationRules[key](element);

                if (error)
                {
                    elementErrors.push(error);
                }
            }
        }

        if (elementErrors.length)
        {
            return elementErrors;
        }
    },

    renderErrorMessages: function(errors)
    {
        var errorsBlock;

        for (var i = 0, length = errors.length; i < errors.length; i++ )
        {
            errorsBlock = validator.constructErrorsMessagesBlock(errors[i].errors);
            var cleanerDiv = document.createElement('div');
            cleanerDiv.setAttribute('class', 'cleaner');
            this.renderedErrorBlocks.push(cleanerDiv);
            this.renderedErrorBlocks.push(errorsBlock);
            errors[i].element.parentNode.appendChild(cleanerDiv);
            errors[i].element.parentNode.appendChild(errorsBlock)
        }

    },

    removeErrorsFromPreviousValidation: function()
    {
       for(var i = 0, length = this.renderedErrorBlocks.length; i < length; i++)
       {
           this.renderedErrorBlocks[i].parentNode.removeChild(this.renderedErrorBlocks[i]);
       }
       this.renderedErrorBlocks = new Array();
    },

    constructErrorsMessagesBlock: function(errorMessages)
    {
        var textBlock = '', errorsDiv;

        for (var i = 0, length = errorMessages.length; i < length; i++ )
        {
            textBlock += '<div>' + errorMessages[i] + '</div>';
        }

        errorsDiv = document.createElement('div');
        errorsDiv.setAttribute('class', 'errors');
        errorsDiv.innerHTML = textBlock;

        return errorsDiv;
    },

    addValidationRule: function(validationRuleClass, validationRuleFunction)
    {
        this.validationRules['validationRuleClass'] = validationRuleFunction;
    }


}
