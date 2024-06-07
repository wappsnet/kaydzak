'use strict';
const path = require('path');
const fs = require('fs');

const theme_folder = path.resolve('.\\') + "\\wp-content\\themes\\wappsnet\\";

function Plugin() {

    function generateMainJs(callback) {
        let js_modules = getDirectories(theme_folder + "modules", 'js');
        let js_plugins = getDirectories(theme_folder + "plugins", 'js');
        let js_builder = theme_folder + "assets\\js\\index.js";

        copy_to_tmp(js_builder, function () {
            let imports = "\r\n";

            js_modules.map(function (item, index) {
                imports += "import 'modules/" + item + "/index.js';\r\n";
            });

            js_plugins.map(function (item, index) {
                imports += "import 'plugins/" + item + "/index.js';\r\n";
            });

            fs.appendFile(js_builder, imports, function (err) {
                console.log("\r\n********************WAPPSNET MODULES JS START****************************\r\n");

                console.log(imports);

                console.log("\r\n********************WAPPSNET MODULES JS END****************************\r\n");

                if(typeof callback === 'function') {
                    callback();
                }
            });
        });

    }

    function generateMainScss(callback) {
        let sass_modules = getDirectories(theme_folder + "modules", 'scss');
        let sass_plugins = getDirectories(theme_folder + "plugins", 'scss');
        let sass_builder = theme_folder + "assets\\sass\\index.scss";

        copy_to_tmp(sass_builder, () => {
            let imports = "\r\n";

            sass_modules.map(function (item, index) {
                imports += "@import '../../modules/" + item + "/index';\r\n";
            });

            sass_plugins.map(function (item, index) {
                imports += "@import '../../plugins/" + item + "/index';\r\n";
            });

            fs.appendFile(sass_builder, imports, (err) => {
                console.log("\r\n********************WAPPSNET MODULES CSS START****************************\r\n");

                console.log(imports);

                console.log("\r\n******************WAPPSNET MODULES CSS END****************************\r\n");

                if(typeof callback === 'function') {
                    callback();
                }
            });
        });
    }

    function getDirectories(srcpath, type) {
        return fs.readdirSync(srcpath).filter(function (file) {
            return (fs.statSync(path.join(srcpath, file)).isDirectory() && fileExists(path.join(srcpath, file) + '/index.' + type));
        });
    }

    function copy_to_tmp(file, callback) {
        let rs = fs.createReadStream(file);
        let ws = fs.createWriteStream(file + '.tmp');
        rs.pipe(ws);
        ws.on('close', callback);
    }

    function fileExists(filePath) {
        try {
            return fs.statSync(filePath).isFile();
        } catch (err) {
            return false;
        }
    }

    this.apply = function (compiler) {

        compiler.plugin("make", function (compilation, webpack_make_callback) {
            generateMainJs(function () {
                generateMainScss(function () {
                    webpack_make_callback();
                });
            });
        });

        compiler.plugin("done", function () {
            let sass_builder = theme_folder + "assets/sass/index.scss";
            let js_builder = theme_folder + "assets/js/index.js";

            fs.unlink(sass_builder, function () {
                console.log("sass builder removed");
            });

            fs.unlink(js_builder, function () {
                console.log("js builder removed");
            });

            fs.rename(sass_builder + '.tmp', sass_builder, () => {
                console.log("DONE CSS");
            });
            fs.rename(js_builder + '.tmp', js_builder, () => {
                console.log("DONE JS");
            });
        });
    }

}

module.exports = Plugin;
