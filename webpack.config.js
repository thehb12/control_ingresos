const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}
Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .addEntry('profile', './assets/profile.js')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .copyFiles({ from: './node_modules/bootstrap/dist', to: 'bootstrap/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/bootstrap-table/dist', to: 'bootstrap-table/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/bootstrap-icons/font', to: 'bootstrap-icons/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/boxicons/css', to: 'boxicons/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/quill/dist', to: 'quill/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/toastr/build', to: 'toastr/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/jquery-ui/dist', to: 'jquery-ui/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/jquery/dist', to: 'jquery/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/jquery-confirm/dist', to: 'jquery-confirm/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/fontawesome-free/css', to: 'fontawesome-free/css/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/fontawesome-free/js', to: 'fontawesome-free/js/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/apexcharts/dist', to: 'apexcharts/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/echarts/dist', to: 'echarts/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/remixicon/fonts', to: 'remixicon/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/simple-datatables/dist', to: 'simple-datatables/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/tinymce', to: 'tinymce/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/chart.js/dist', to: 'chart.js/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/animate.css', to: 'animate.css/[path][name].[ext]' })
    .copyFiles({ from: './node_modules/sweetalert2/dist', to: 'sweetalert2/[path][name].[ext]' })
    .copyFiles({ from: './assets', to: '[path][name].[ext]', pattern: /main\.js$/ })
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })
    ;
module.exports = Encore.getWebpackConfig();
