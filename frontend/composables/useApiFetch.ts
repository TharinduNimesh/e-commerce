import type { UseFetchOptions } from "#app";
import { useErrorHandler } from "./useErrorHandler";

export async function useApiFetch<T>(
  path: string | (() => string),
  options: UseFetchOptions<T> = {},
  notify = true
) {
  let headers: any = {
    Accept: "application/vnd.api+json",
    "Content-Type": "application/vnd.api+json",
  };

  const token = useCookie("XSRF-TOKEN");
  const auth_token = localStorage.getItem("auth-token");

  if (token.value) {
    headers["X-XSRF-TOKEN"] = token.value as string;
    headers["Authorization"] = auth_token ? auth_token : "";
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
      if (notify) {
        useErrorHandler(error.value.data);
      }
      return {
        data: null,
        pending: false,
      };
    }
    return {
      data: data.value,
      pending: pending.value,
    };
  } catch (err) {
    if (notify) {
      useErrorHandler(err);
    }
    return {
      data: null,
      pending: false,
    };
  }
}
