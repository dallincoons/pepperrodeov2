/*
 * Load Vue & Vue-Resource.
 *
 * Vue is the JavaScript framework used by Spark.
 */
if (window.Vue === undefined) {
    window.Vue = require('vue');

    window.Bus = new Vue();
}

/**
 * Define the Vue filters.
 */
require('./filters');

/**
 * Load the Spark form utilities.
 */
require('./forms/bootstrap');
