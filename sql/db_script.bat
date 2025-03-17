@REM Insertion des données dans la base de données
@echo off
setlocal enabledelayedexpansion

@REM Files names
@REM db_create.sql : script de création de la base de données
@REM db_insert.sql : script d'insertion des données dans la base de données

@REM Check if mysql is installed
@REM If not, exit the script

:: Vérifier si MySQL est installé
where mysql >nul 2>nul
if %errorlevel% neq 0 (
    echo MySQL n'est pas installé. Veuillez l'installer et réessayer.
    pause
    exit /b 1
)

:: Demander le mot de passe utilisateur
set /p MYSQL_PWD="Entrez votre mot de passe MySQL : "

:: Exécuter les scripts SQL
echo Execution des scripts SQL...
mysql -u root -p%MYSQL_PWD% -e "source db_create.sql;"
if %errorlevel% neq 0 (
    echo Erreur lors de l'exécution de db_create.sql.
    pause
    exit /b 1
)

mysql -u root -p%MYSQL_PWD% -e "source db_insert.sql;"
if %errorlevel% neq 0 (
    echo Erreur lors de l'exécution de db_insert.sql.
    pause
    exit /b 1
)

:: Fin du script
echo Tout s'est bien passé !
pause
exit /b 0
