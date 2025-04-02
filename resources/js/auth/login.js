import {formatErrors422} from "@/plugins/helper.js";

const form = document.getElementById('formulario-login');

form.addEventListener('submit', async function (e) {
    e.preventDefault();
    await postLogin();
});

async function postLogin() {
    const formData = new FormData(form);

    try {
        const response = await axios.post('/login', formData);

        await toast.fire({
            timer: 2000,
            icon: 'success',
            title: 'Sucesso',
            text: response.data.message
        })
        window.location.href = '/home';

    } catch (error) {
        let title = error?.response?.data?.message

        let message = null;

        if (error.status === 422) {
            message = formatErrors422(error?.response?.data?.error);
        }
        await toast.fire({
            icon: 'error',
            title: title,
            html: message
        });
    }
}
