import Token from './Token';
import AppStorage from './AppStorage';

class User {
    responseAfterLogin(res) {
        const accessToken = res.data.access_token;
        const username = res.data.name;
        if (Token.isValid(accessToken)) {
            AppStorage.store(accessToken, username);
        }
    }

    hasToken() {
        const storedToken = AppStorage.getToken();
        if (storedToken) {
            return Token.isValid(storedToken);
        }
        return false;
    }

    loggedIn() {
        return this.hasToken();
    }

    name() {
        if (this.loggedIn()) {
            return AppStorage.getUser();
        }
        return null;
    }

    id() {
        if (this.loggedIn()) {
            const payload = Token.payload(AppStorage.getToken());
            return payload ? payload.sub : null;
        }
        return false;
    }

    logout() {
        AppStorage.clear();
    }
}

export default new User();
