echo %date% %time% - Deploying...>github_hook.txt
git reset --hard HEAD
git pull
echo %date% %time% - Online!>>github_hook.txt
