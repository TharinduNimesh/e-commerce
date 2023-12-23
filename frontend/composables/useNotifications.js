export const useNotifications = () => {
    let notifications = [];
    return useState('notifications', () => {
        return {
            notifications
        }
    });
}