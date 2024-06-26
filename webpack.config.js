const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}
Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .addEntry('profile', './assets/profile.js')
    .addEntry('bootstrap', './assets/bootstrap.js')
    .addEntry('trabajadores', './assets/trabajadores.js')
    .addEntry('trasacciones', './assets/trasacciones.js')
    .addEntry('codigo', './assets/codigo.js')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })
    .enableSassLoader()
    .enableTypeScriptLoader()
    .copyFiles({ from: './node_modules/jquery/dist', to: 'jquery/[path][name].[ext]', pattern: /jquery\.min\.js$/ })
    ;
module.exports = Encore.getWebpackConfig();
