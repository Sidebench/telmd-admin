try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = require('popper.js/dist/umd/popper.js');
    require('bootstrap-sass');

    require('./plugins/simplebar/simplebar');
    require('./plugins/nestable/jquery.nestable.js');
    require('./plugins/select2/select2.min.js');
    require('./plugins/bootstrap/bootstrap-treeview.min.js');
    require('./plugins/chart/Chart.min.js');
    
    require('./theme/waves');
    require('./theme/sidebar-menu');
    require('./theme/bootstrap-datepicker');
    require('./theme/jquery.steps');
    require('./theme/grids');
    require('jquery-validation');

    require('./theme/app-script');

} catch (e) {}

window.setLocation = function(urlLink) {
    window.location.href = urlLink;
}

window.confirmSetLocation = function(urlLink) {
    $("#confirm-action").modal('show');
    $("#confirm-action .btn-primary").click(function() {
        window.location.href = urlLink;
    });
}

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};
