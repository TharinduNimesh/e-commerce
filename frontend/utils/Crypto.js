import CryptoJS from 'crypto-js';

const PRIVATE_KEY = 'f538612bf21ec0064fb91f36fc9fa8a65a9321a19cc1721a14b0402b6a8de62de7a7e1d7d4252dc03ac0749d80284facd0b67357c8acead8efceb531be3fd64e';

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