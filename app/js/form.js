$(document).ready(function () {
    $('input, select').blur(function (e) {
        $(this).val($(this).val().trim());
        var valid = e.target.checkValidity();
        console.log('valid: ', valid);
        if (valid) {
            var parentGroup = $(this).closest('.form-group');
            parentGroup.removeClass('has-error');
            parentGroup.removeClass(function (index, classes) {
                return classes.split(/\s+/).filter(function (el) {
                    return /^error-/.test(el);
                }).join(' ');
            });
        }
    }).bind('invalid', function (e) {
        e.target.setCustomValidity('');
        var parentGroup = $(this).closest('.form-group');
        parentGroup.addClass('has-error');
        if (e.target.validity.valueMissing) {
            e.target.setCustomValidity($(this).data('error-required'));
            parentGroup.addClass('error-required');
        } else if (e.target.validity.patternMismatch) {
            e.target.setCustomValidity($(this).data('error-pattern'));
            parentGroup.addClass('error-pattern');
        } else if (e.target.validity.patternMismatch) {
            e.target.setCustomValidity($(this).data('error-mismatch'));
            parentGroup.addClass('error-mismatch');
        } else if (e.target.validity.typeMismatch) {
            e.target.setCustomValidity($(this).data('error-type'));
            parentGroup.addClass('error-type');
        }
    });
});