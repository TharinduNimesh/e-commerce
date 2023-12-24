export const useAuth = async () => {
    let user;
    if (user === undefined) {
        const { data } = await useApiFetch("/api/user");
        if(data) {
            user = data.user;
        }
    }

    return useState(() => ({ user }));
};