import { route as routeFn } from 'ziggy-js';

/**
 *
 */
declare global {
    let route: typeof routeFn;
}

/**
 *
 */
declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof routeFn;
    }
}
