interface FormData {
  [key: string]: any;
}

export default function useFormReset(form: FormData) {
  Object.keys(form).forEach((key: string) => {
    form[key] = "";
  });
  return form;
}
