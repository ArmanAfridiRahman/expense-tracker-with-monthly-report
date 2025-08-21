document.addEventListener('DOMContentLoaded', function() {
    
    document.querySelectorAll('.toast').forEach(function(toastElement) {
        
        const toast = new bootstrap.Toast(toastElement, {
            autohide: toastElement.dataset.bsAutohide !== 'false',
            delay: parseInt(toastElement.dataset.bsDelay) || 3000
        });
        
        toast.show();
        
        toastElement.style.opacity = '0';
        toastElement.style.transform = 'translateX(100%)';
        
        setTimeout(() => {
            toastElement.style.transition = 'all 0.3s ease-in-out';
            toastElement.style.opacity = '1';
            toastElement.style.transform = 'translateX(0)';
        }, 100);
    });
});