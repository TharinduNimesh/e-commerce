import type { UseFetchOptions } from "#app";
import { useErrorHandler } from "./useErrorHandler";

export async function useApiFetch<T>(
  path: string | (() => string),
  options: UseFetchOptions<T> = {}
) {
  let headers: any = {};

  const token = useCookie("XSRF-TOKEN");
  if (token.value) {
    headers["XSRF-TOKEN"] = token.value as string;
  }

  try {
    const { data, error, pending } = await useFetch(
      "http://api.eshop.viva" + path,
      {
        credentials: "include",
        watch: false,
        ...options,
        headers: {
          ...headers,
          ...options?.headers,
        },
      }
    );

    if (error.value) {
      useErrorHandler(error.value.data);
      return {
        data: null,
        pending: false,
      };
    } else {
      return {
        data: data.value,
        pending: pending.value,
      };
    }
  } catch (err) {
    useErrorHandler(err);
  }
}
