#!/bin/bash
# Assuming that the setup is pulled
# git clone https://github.com/arminezu6yn4xgma0i/mac-setup-script.git
# Assuming that im in Projects/mac-setup-script

set -euo pipefail

# Check that the script is run as a regular user (not as root)
if [[ $(id -u) -eq 0 ]]; then
  printf "This script should not be run as root. Please run it as a regular user.\n" >&2
  exit 1
fi


install_homebrew() {
    if ! command -v brew &>/dev/null; then
        /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
    else
        echo "Homebrew is already installed."
    fi
}

install_zsh() {
    if ! command -v zsh &>/dev/null; then
        brew install zsh
        chsh -s $(which zsh)
    fi
}

install_starship() {
    if ! command -v starship &>/dev/null; then
        brew install starship
    fi
}

install_ohmyzsh() {
    if [ ! -d "$HOME/.oh-my-zsh" ]; then
        sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)"
        cp ~/.zshrc ~/.zshrc.bak
        cat ~/Projects/mac-setup-script/.zshrc > ~/.zshrc
    fi
}

configure_git() {
    echo ""
    echo "Configuring git..."
    echo "Write your git username"
    read USER
    DEFAULT_EMAIL="$USER@users.noreply.github.com"
    read -p "Write your git email [Press enter to accept the private email $DEFAULT_EMAIL]: " EMAIL
    EMAIL="${EMAIL:-${DEFAULT_EMAIL}}"
    echo "Configuring global user name and email..."
    git config --global user.name "$USER"
    git config --global user.email "$EMAIL"
    git config --global credential.helper 'cache --timeout=36000'
}

configure_ssh() {
    echo ""
    read -r -p "Do you want to add ssh credentials for git? [y/n] " RESP
    RESP=${RESP,,} # tolower (only works with /bin/bash)
    CHECK_KEY_ED_EXISTS="$HOME/.ssh/id_rsa.pub"
    if [[ $RESP =~ ^(yes|y)$ ]] && ! test -f "$CHECK_KEY_ED_EXISTS"; then
        echo "Configuring git ssh access..."
        ssh-keygen -t rsa -C "$EMAIL"
        echo "This is your public key. To activate it in github, got to settings, SHH and GPG keys, New SSH key, and enter the following key:"
        cat ~/.ssh/id_rsa.pub
        echo -e "\nTo work with the ssh key, you have to clone all your repos with ssh instead of https."
    elif [[ $RESP =~ ^(yes|y)$ ]] && test -f "$CHECK_KEY_ED_EXISTS"; then
        echo "You have already ssh-key. To activate it in github, got to settings, SHH and GPG keys, New SSH key, and enter the following key:"
        cat ~/.ssh/id_rsa.pub
    fi
}

# Install packages from Brewfile
brew bundle check --global
if [ $? -eq 0 ]; then
    brew bundle install --global -f
    brew update
    brew upgrade
else
    echo "Some dependencies are missing. Would you like to install them now? [y/n]"
    read answer
    if [ "$answer" == "y" ]; then
        missing=$(brew bundle check --global | grep 'is not installed' | awk '{print $1}')
        echo "Installing missing dependencies: $missing"
        brew install $missing
        brew bundle install --global -f
        brew update
        brew upgrade
    else
        echo "Please install the missing dependencies and try again."
        exit 1
    fi
fi

# Cleanup
brew cleanup

install_homebrew
install_zsh
install_ohmyzsh
install_starship
configure_git

exit 0
