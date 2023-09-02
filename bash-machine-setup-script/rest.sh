remove_paths() {
  if [ -z "$dry_run" ]; then
    for path in "${path_list[@]}"; do
      rm -rfv "$path" &>/dev/null
    done
    unset path_list
  fi
}

sudo -v

collect_paths() {
  path_list+=("$@")
}

collect_paths /Volumes/*/.Trashes/*
collect_paths ~/.Trash/*
msg 'Emptying the Trash 🗑 on all mounted volumes and the main HDD...'
remove_paths

collect_paths /Library/Caches/*
collect_paths /System/Library/Caches/*
collect_paths ~/Library/Caches/*
collect_paths /private/var/folders/bh/*/*/*/*
msg 'Clearing System Cache Files...'
remove_paths
collect_paths /private/var/log/asl/*.asl
collect_paths /Library/Logs/DiagnosticReports/*
collect_paths ~/Library/Containers/com.apple.mail/Data/Library/Logs/Mail/*
collect_paths ~/Library/Logs/CoreSimulator/*

collect_paths ~/Library/Application\ Support/Google/Chrome/Default/Application\ Cache/*
msg 'Clearing Google Chrome Cache Files...'
collect_paths ~/Library/Application\ Support/MobileSync/Backup/*
msg 'Removing iOS Device Backups...'

collect_paths ~/Library/Developer/Xcode/DerivedData/*
collect_paths ~/Library/Developer/Xcode/Archives/*
collect_paths ~/Library/Developer/Xcode/iOS Device Logs/*
msg 'Cleaning up XCode Derived Data and Archives...'

    msg 'Cleaning up composer...'
    composer clearcache --no-interaction &>/dev/null

     collect_paths ~/wget-log
  collect_paths ~/.wget-hsts
  msg 'Deleting Wget log and hosts file...'

   brew cleanup -s &>/dev/null
    brew tap --repair &>/dev/null

    msg 'Cleaning up Docker'
    docker system prune -af &>/dev/null

      collect_paths "$PYENV_VIRTUALENV_CACHE_PATH"
  msg 'Removing Pyenv-VirtualEnv Cache...'

      msg 'Cleaning up npm cache...'
    npm cache clean --force &>/dev/null

      msg 'Cleaning up DNS cache...'
  sudo dscacheutil -flushcache &>/dev/null
  sudo killall -HUP mDNSResponder &>/dev/null

    msg 'Purging inactive memory...'
  sudo purge &>/dev/null

for path in "${path_list[@]}"; do
      rm -rfv "$path" &>/dev/null
    done
    unset path_list