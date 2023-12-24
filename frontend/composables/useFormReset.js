export default function useFormReset(form) {
    if (typeof (form) == 'object') {
        Object.keys(form).forEach(key => {
            form[key] = '';
        });
    }
    return form;
}