var GlobalScript = {
    init: function(){
        // Inicializações globais, se necessário
    },
    showSuccessMessage: function(title, message) {
        Swal.fire(title, message, 'success');
    },
    showErrorMessage: function(title, message) {
        Swal.fire(title, message, 'error');
    },
    showInfoMessage: function(message) {
        Swal.fire('Informação', message, 'info');
    }
}

$(document).ready(function(){
    GlobalScript.init();
});
