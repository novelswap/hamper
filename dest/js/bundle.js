(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

$('#loginForm').on('submit', function () {
  $.ajax({
    type: "POST",
    url: "./php/login.php",
    dataType: "JSON",
    data: $('#loginForm').serialize(),
    success: function success(data) {
      if (data.status === 'success') {
        window.location = 'customer/index.php';
      } else {
        $('.errorMessage').fadeIn().html(data.message);
      }
    }
  });
  return false;
});

$('#signupForm').on('submit', function () {
  $.ajax({
    type: "POST",
    url: "./php/signup.php",
    dataType: "JSON",
    data: $('#signupForm').serialize(),
    success: function success(data) {
      if (data.status === 'success') {
        $('#signupForm').slideUp();
        $('.successMessage').fadeIn().html(data.message);
        $('.errorMessage').fadeOut();
      } else {
        $('.errorMessage').fadeIn().html(data.message);
      }
    }
  });

  return false;
});

},{}]},{},[1])

//# sourceMappingURL=bundle.js.map
