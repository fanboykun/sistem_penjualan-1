import Swal from 'sweetalert2'

export default class entahNamaDariClassKurangPenting {
    df102() {
        Swal.mixin({
            title: 'Dalam Proses .. ',
            icon: 'info',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timerProgressBar: false,
            showCloseButton: true,
        }).fire();
    }

    df200() {
        Swal.mixin({
            title: 'Proses Berhasil .. ',
            icon: 'success',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
        }).fire();
    }

    df500() {
        Swal.mixin({
            title: 'Terjadi Kelas Server .. ',
            icon: 'warning',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
        }).fire();
    }
}
