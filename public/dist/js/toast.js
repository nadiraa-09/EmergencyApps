const Toast = Swal.mixin({
    toast: true,
    showConfirmButton: false,
    timerProgressBar: true,
    iconColor: 'white',
    customClass: {
        popup: 'colored-toast'
    },
})

const successToast = async (data) => {
    await Toast.fire({
        icon: 'success',
        position: 'bottom-end',
        title: `${data}`,
        timer: 2000
    })
}

const errorToast = async (data) => {
    await Toast.fire({
        icon: 'error',
        position: 'center',
        title: `${data}`,
        timer: 3000
    })
}