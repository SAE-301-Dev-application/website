function ajax(method, routePath, data, done = () => {}, fail = () => {}, always = () => {}) {
    $[method](routePath, data)
        .done(done)
        .fail(fail)
        .always(always);
}