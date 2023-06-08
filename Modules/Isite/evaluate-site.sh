#!/bin/bash
RED='\033[0;31m' #Red Color
NC='\033[0m' # No Color
GREEN='\033[0;32m' # Green
YELLOW='\033[0;33m'  # Yellow

icmsSize=$(du -s ./ | cut -f1)

	        printf "-----------------------------------------------------------------\n"
	printf "${GREEN}-----------------CMS SUPERVISOR ---------------------------------${NC}\n"
	        printf "-----------------------------------------------------------------\n"

if [ $icmsSize -gt 389120 ]; then
	printf "${RED}---The App is consuming a high disk space: $(du -sh)${NC}\n"
else
	printf "${GREEN}The App has a good space consumption!${NC}\n"
fi

du -s * | sort -h |
while read size name
do
case $name in
	storage)
    if [ $size -gt 25600 ]; then #greater than 25Mb
			set -- `du -sh $name`
      printf "${RED}---The storage folder is greater than expected (25Mb), found $1${NC} (ignore this if the App is using the Idocs Module)\n"
      printf "${YELLOW}Optimizing storage folder...${NC}\n"
      printf "${YELLOW}Deleting laravel logs...${NC}\n"
      rm storage/logs/* 2>/dev/null
      printf "${YELLOW}Deleting laravel debugbar...${NC}\n"
      rm storage/debugbar/* 2>/dev/null
      printf "${YELLOW}Reevaluating storage folder...${NC}\n"
      set -- `du -s $name`
      if [ $size -gt 25600 ]; then #greater than 5Mb
	      set -- `du -sh $name`
        printf "${RED}---The storage folder still getting bigger than expected (25Mb), found $1${NC} (ignore this if the App is using the Idocs Module)\n"
      else
        printf "${GREEN}The storage folder is now lower than expected (25Mb), found $1${NC}\n"
      fi
    else
      set -- `du -s $name`
      printf "${GREEN}The storage folder is lower than expected (5Mb), found $1${NC}\n"
		fi
	;;
	public)
		if [ $size -gt 1048576 ]; then #greater than 1Gb
			set -- `du -sh $name`
			printf "${RED}---The public folder is greater than expected (1Gb), found $1${NC}\n"
      printf "${YELLOW}Maybe this site doesn't have an S3 configured ? ${NC}\n"
		fi
	;;
	Themes)
		if [ $size -gt 40960 ]; then #greater than 40Mb
			set -- `du -sh $name`
			printf "${RED}---The Themes folders is greater than expected (40Mb), found: $1${NC}\n"
      printf "${YELLOW}Optimizing Themes folder...${NC}\n"
      printf "${YELLOW}Deleting AdminLTE assets...${NC}\n"
      rm -rf Themes/Adminlte/assets/* 2>/dev/null
      printf "${YELLOW}Deleting ImaginaTheme node_modules folder...${NC}\n"
      rm -rf Themes/ImaginaTheme/node_modules 2>/dev/null
      printf "${YELLOW}Reevaluating Themes folder...${NC}\n"
      set -- `du -sh $name`
      if [ $size -gt 40960 ]; then #greater than 40Mb
        printf "${RED}---The Themes folders is greater than expected (40Mb), found: $1${NC} (Maybe this project has an extra files in the Themes folder?)\n"
      else
       printf "${GREEN}The Themes folder is now lower than expected (40Mb), found $1${NC}\n"
      fi
    else
    set -- `du -sh $name`
       printf "${GREEN}The Themes folder is now lower than expected (40Mb), found $1${NC}\n"
    fi
	;;
esac

done

printf "\n${YELLOW}Checking Github repository${NC}\n"
gitStatus=$(git status)

if [[ "$gitStatus" == *"On branch master"* ]]; then
  printf "${GREEN}Great, this project is in the branch master.${NC}\n"
else
  printf "${RED}---This project isn't in the branch master.${NC}\n"
fi

if [[ "$gitStatus" == *"nothing to commit, working tree clean"* ]]; then
  printf "${GREEN}Great, there is nothing to commit, working tree clean!.${NC}\n"
else
  printf "${RED}---There are changes waiting to commit.${NC}\n\n"
  git status
  printf "\n\n"
fi


printf "\n${YELLOW}Checking .ENV file${NC}\n"
if [ -f .env ]; then
  export $(echo $(cat .env | sed 's/#.*//g'| xargs) | envsubst)

  if [ -n "$APP_NAME" ] && [ $APP_NAME == "Laravel" ]; then
    printf "${RED}---Bad .env APP_NAME, found 'Laravel', it must be an unique name in the server where is runing${NC}\n"
  else
    printf "${GREEN}APP_NAME configured correctly, found $APP_NAME ${NC}¡The APP_NAME must be an unique identifier by App in the server where is runing, make sure there aren't others Apps using the same!${NC}\n"
  fi

if [ -n "$APP_ENV" ] && [ $APP_NAME == "local" ]; then
    printf "${RED}---Bad .env APP_ENV, found 'local', it must be 'production'${NC}\n"
  else
    printf "${GREEN}APP_ENV configured correctly!${NC}\n"
  fi

  if [ -n "$APP_CACHE" ] && [ $APP_CACHE == false ]; then
    printf "${RED}---Bad .env APP_CACHE, found false, it must be true (To turn on the APP_CACHE you must to modify some public configs and update entirely the submodules)${NC}\n "
  else
    printf "${GREEN}APP_CACHE configured correctly!${NC}\n"
  fi

 if [ -n "$RESPONSE_CACHE_ENABLED" ] && [ $RESPONSE_CACHE_ENABLED == false ]; then
    printf "${RED}---Bad .env RESPONSE_CACHE_ENABLED, found false, it must be true ${NC}\n "
  else
    printf "${GREEN}RESPONSE_CACHE_ENABLED configured correctly!${NC}\n"
  fi


 if [ -n "$RESPONSE_CACHE_LIFETIME" ] && [ $RESPONSE_CACHE_LIFETIME == 31104000 ]; then
   printf "${GREEN}RESPONSE_CACHE_LIFETIME configured correctly!${NC}\n"
  else
   printf "${RED}---Bad .env RESPONSE_CACHE_LIFETIME, not found or with a different value than expected, it must be 31104000 ${NC}\n "

  fi


 if [ -n "$RESPONSE_CACHE_DRIVER" ] && [ $RESPONSE_CACHE_DRIVER == "redis" ]; then
   printf "${GREEN}RESPONSE_CACHE_DRIVER configured correctly!${NC}\n"
  else
   printf "${RED}---Bad .env RESPONSE_CACHE_DRIVER, not found or with a different value than expected, it must be 'redis' ${NC}\n "

  fi


 if [ -n "$LOG_CHANNEL" ] && [ $LOG_CHANNEL == "daily" ]; then
   printf "${GREEN}LOG_CHANNEL configured correctly!${NC}\n"
  else
   printf "${RED}---Bad .env LOG_CHANNEL, not found or with a different value than expected, it must be 'daily' ${NC}\n "

  fi


 if [ -n "$CACHE_DRIVER" ] && [ $CACHE_DRIVER == "redis" ]; then
   printf "${GREEN}CACHE_DRIVER configured correctly!${NC}\n"
  else
   printf "${RED}---Bad .env CACHE_DRIVER, not found or with a different value than expected, it must be 'redis' ${NC}\n "

  fi


 if [ -n "$TRANSLATIONS_CACHE_DRIVER" ] && [ $TRANSLATIONS_CACHE_DRIVER == "redis" ]; then
   printf "${GREEN}TRANSLATIONS_CACHE_DRIVER configured correctly!${NC}\n"
  else
   printf "${RED}---Bad .env TRANSLATIONS_CACHE_DRIVER, not found or with a different value than expected, it must be 'redis' ${NC}\n "

  fi


 if [ -n "$CACHE_TIME" ] && [ $CACHE_TIME == 31104000 ]; then
   printf "${GREEN}CACHE_TIME configured correctly!${NC}\n"
  else
   printf "${RED}---Bad .env CACHE_TIME, not found or with a different value than expected, it must be 31104000 ${NC}\n "

  fi

 if [ -n "$QUEUE_CONNECTION" ] && [ $QUEUE_CONNECTION == "database" ]; then
   printf "${YELLOW}QUEUE_CONNECTION is in 'database' mode, make sure the server has runing the CRON and SUPERVISOR services!${NC}\n"
  fi



else
  printf "${RED}---ERROR:: .env file is missing ${NC}\n"
fi


