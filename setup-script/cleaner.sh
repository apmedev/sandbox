#!/bin/bash

# Set shell options
set -e

# Define directories to clean up
LOG_DIR=~/private/var/log/*
CACHE_DIRS=(
  ~/Library/Caches/*
  ~/var/log/*
  ~/Library/Application\ Support/Google/Chrome/Default/Application\ Cache/*
)

# Get the current date and time
now=$(date +"%Y-%m-%d %T")

# Define functions
log() {
  echo "[$(date +"%Y-%m-%d %T")] $1"
}

cleanup_logs() {
  log "Cleaning up log files..."
  rm -rfv "$LOG_DIR".asl
}

cleanup_caches() {
  log "Cleaning up cache directories..."
  for dir in "${CACHE_DIRS[@]}"; do
    rm -rfv "$dir"
  done
}

cleanup_composer() {
  log "Clearing composer cache..."
  composer clearcache --no-interaction
}

cleanup_brew() {
  log "Updating Homebrew..."
  brew update > /dev/null

  if [ -n "$(brew outdated)" ]; then
    log "Updates available:"
    brew outdated
    log "Upgrading packages..."
    brew upgrade
  else
    log "No updates available"
  fi

  log "Cleaning up Homebrew cache..."
  brew cleanup -s
  brew tap --repair
}

cleanup_docker() {
  log "Pruning Docker system..."
  docker system prune -af
}

flush_dns_cache() {
  log "Flushing DNS cache..."
  sudo dscacheutil -flushcache
  sudo killall -HUP mDNSResponder
}

cleanup_system() {
  log "Purging system memory..."
  sudo purge
}

sudo -v

periodic daily weekly monthly

# Perform cleanup tasks
cleanup_logs
cleanup_caches
cleanup_brew
cleanup_docker
flush_dns_cache
cleanup_system
cleanup_composer

log "Done."
exit 0