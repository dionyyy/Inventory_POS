class Token {
    isValid(token) {
        const payload = this.payload(token);
        return Boolean(payload && payload.sub);
    }

    payload(token) {
        if (!token || token.split('.').length < 2) {
            return null;
        }
        return this.decode(token.split('.')[1]);
    }

    decode(payload) {
        try {
            return JSON.parse(atob(payload));
        } catch (e) {
            return null;
        }
    }
}

export default new Token();
