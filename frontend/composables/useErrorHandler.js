export const useErrorHandler = (errors) => {
    if (typeof (errors) === 'object') {
        errors = Object.values(errors);
        if (errors.length > 0) {
            errors = errors[0];
            if (Array.isArray(errors)) {
                useNotifications().value.push({
                    type: 'error',
                    message: errors[0]
                });
            } else {
                useNotifications().value.push({
                    type: 'error',
                    message: errors
                });
            }
        }
    } else {
        useNotifications().value.push({
            type: 'error',
            message: errors
        });
    }
}