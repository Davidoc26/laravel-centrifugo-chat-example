import Centrifugo from "./centrifugo";

(window as any)._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
(window as any).centrifugo = Centrifugo;

(window as any).axios = require('axios');

(window as any).axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

