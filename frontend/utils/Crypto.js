import CryptoJS from 'crypto-js';

const PRIVATE_KEY = import.meta.env.VITE_PW_PRIVATE_KEY;

export const Crypto = {
    encrypt: (text) => {
        const encrypted = CryptoJS.AES.encrypt(text, PRIVATE_KEY).toString();
        return encrypted;
    },
    decrypt: (text) => {
        const decrypted = CryptoJS.AES.decrypt(text, PRIVATE_KEY).toString(CryptoJS.enc.Utf8);
        return decrypted;
    }
}