if (!(test-path "modules/Core/script.ps1"))
{
    if (!(test-path "modules"))
    {
        mkdir "modules"
    }
    if (!(test-path "modules/Core"))
    {
        mkdir "modules/Core"
    }
    git clone "https://github.com/GreenCodeStudio/GreenCodeFramework-Core.git" "./modules/Core"
}
. ./modules/Core/script.ps1