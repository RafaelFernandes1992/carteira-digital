export function formatErrors422(errors) {
    let errorMessage = '';

    Object.keys(errors).forEach(field => {
        errors[field].forEach(message => {
            errorMessage += `${message}<br>`;
        });
    });

    return errorMessage;
}