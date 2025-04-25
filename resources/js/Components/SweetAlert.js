import Swal from 'sweetalert2';

export const showSuccessNotification = (message) => {
    Swal.fire({
        title: 'Succès!',
        text: message,
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#4F46E5',
    });
};

export const showErrorNotification = (message) => {
    Swal.fire({
        title: 'Erreur!',
        text: message,
        icon: 'error',
        confirmButtonText: 'OK',
        confirmButtonColor: '#4F46E5',
    });
};

export const showConfirmDialog = (title, text) => {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4F46E5',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui',
        cancelButtonText: 'Annuler'
    });
};