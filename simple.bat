@echo off
IF "%1"=="serve" (
    php -S localhost:80
) ELSE IF "%1"=="build" (
    echo Not yet implemented
) ELSE (
    echo Usage: %0 serve
)