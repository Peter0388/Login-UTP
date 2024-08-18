document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        // Seleccionar mensajes específicos
        var messages = ['#error-message-incorrect', '#error-message-blocked', '#logout-message', '#attempts-message'];
        
        messages.forEach(function(selector) {
            var element = document.querySelector(selector);
            if (element) {
                // Aplicar desvanecimiento gradual
                element.style.transition = 'opacity 0.5s ease-out';
                element.style.opacity = '0';

                setTimeout(function() {
                    element.style.display = 'none';
                }, 500); // 0.5 segundos
            }
        });
    }, 2000); 
});