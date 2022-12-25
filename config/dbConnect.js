var mysql = require('mysql');

var con = mysql.createConnection({
    host: "containers-us-west-58.railway.app",
    user: "root",
    password: "jCTG3kIHO7Uc11FroTGW"
});

con.connect(function (err) {
    if (err) throw err;
    console.log("Connected!");
});