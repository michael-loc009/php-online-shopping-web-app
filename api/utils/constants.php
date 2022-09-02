<?php

$MAX_UPLOAD_FILE_SIZE = 500000;
$TARGET_PRODUCT_PHOTO_DIR = "/assets/products/";
$TARGET_CUSTOMER_PHOTO_DIR = "/assets/customers/";
$DEFAULT_AVATAR_PROFILE_PHOTO = "default_avatar.jpg";


// Http Status Codes
$SUCCESS_STATUS_CODE = "HTTP/1.1 200 OK";
$CREATED_STATUS_CODE = "HTTP/1.1 201 Created";
$BAD_REQUEST_STATUS_CODE = "HTTP/1.1 400 Bad Request";
$NOT_FOUND_STATUS_CODE = "HTTP/1.1 404 Not Found";

// Error codes
$INVALID_FILE_ERROR_CODE = 1;
$LARGE_FILE_ERROR_CODE = 2;
$INVALID_IMAGE_TYPE_ERROR_CODE = 3;
$FAILED_UPLOADED_FILE_ERROR_CODE =4;
$EXISTING_PRODUCT_NAME_ERROR_CODE = 5;
$INVALID_PRICE_ERROR_CODE = 6;
$NON_EXISTING_PRODUCT_ERROR_CODE = 7;

$INVALID_USERNAME_ERROR_CODE = 8;
$EXISTING_USERNAME_ERROR_CODE = 9;
$INVALID_PASSWORD_ERROR_CODE = 10;
$INVALID_ADDRESS_ERROR_CODE = 11;
$INVALID_NAME_ERROR_CODE = 12;
$MISSING_REQUIRED_INPUTS_ERROR_CODE = 13;
$NON_EXISTING_CUSTOMER_ERROR_CODE = 14;

$ERROR_RESPONSE = array();
$ERROR_RESPONSE[$INVALID_FILE_ERROR_CODE] = "Sorry, uploaded file is not an image.";
$ERROR_RESPONSE[$LARGE_FILE_ERROR_CODE] = "Sorry, uploaded file is too large.";
$ERROR_RESPONSE[$INVALID_IMAGE_TYPE_ERROR_CODE] = "Sorry, only JPG, JPEG and PNG files are allowed.";
$ERROR_RESPONSE[$FAILED_UPLOADED_FILE_ERROR_CODE] = "Sorry, there was an error uploading your file.";
$ERROR_RESPONSE[$EXISTING_PRODUCT_NAME_ERROR_CODE] = "Sorry, this product name already exists.";
$ERROR_RESPONSE[$INVALID_PRICE_ERROR_CODE] = "Sorry, product price is invalid";
$ERROR_RESPONSE[$NON_EXISTING_PRODUCT_ERROR_CODE] = "Sorry, product does not exist.";
$ERROR_RESPONSE[$INVALID_USERNAME_ERROR_CODE]= "Sorry, username contains only letters and digits with the length from 8 to 15 characters.";
$ERROR_RESPONSE[$EXISTING_USERNAME_ERROR_CODE]= "Sorry, username already exists.";
$ERROR_RESPONSE[$INVALID_PASSWORD_ERROR_CODE]= "Sorry, password contains at least one upper case letter, at least one lower case latter, at least one digit, at least one special with the length from 8 to 20 characters.";
$ERROR_RESPONSE[$INVALID_ADDRESS_ERROR_CODE]= "Sorry, address is required with the minimum length of 5 characters.";
$ERROR_RESPONSE[$INVALID_NAME_ERROR_CODE]= "Sorry, name is required with the minimum length of 5 characters.";
$ERROR_RESPONSE[$MISSING_REQUIRED_INPUTS_ERROR_CODE] = "Sorry, there are some missing required inputs.";
$ERROR_RESPONSE[$NON_EXISTING_CUSTOMER_ERROR_CODE] = "Sorry, customer does not exist.";