window.addEventListener("load", function() {
    //find all forms with data-confirm-message attribute
    var forms = document.querySelectorAll("form[data-confirm-message]");
    for(var i = 0; i < forms.length; i++) {
        //register submit event handler
        forms[i].addEventListener("submit", function(event) {
            if(!confirm(this.dataset.confirmMessage)) {
                //prevent form from submission
                event.preventDefault();
            }
        });
    }
});