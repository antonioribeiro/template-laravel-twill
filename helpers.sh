#!/usr/bin/env bash
NC='\033[0m' # No Color
YELLOW='\033[0;33m'
CYAN='\033[0;36m'
GREEN='\033[0;32m'
RED='\033[0;31m'
MAGENTA='\033[0;35m'

install() {
  cp "$(dirname $0)/functions.sh .git/hooks"
}

notify_about_actions_required() {
    changed_files="$(git diff-tree -r --name-status --no-commit-id $1 $2)"
    is_changed() {
        echo "$changed_files" | grep -Eq "$1"
    }
    is_added() {
        echo "$changed_files" | grep -Eq "^A\s+$1"
    }
    is_modified() {
         echo "$changed_files" | grep -Eq "^M\s+$1"
    }
    is_deleted() {
         echo "$changed_files" | grep -Eq "^D\s+$1"
    }
    print_notification() {
        filename="$1"
        shift
        action="$@"
        echo -e "${YELLOW}${filename}${NC} changed. Please run ${CYAN}${action}${NC}"
    }
    is_changed composer.lock && print_notification "composer.lock" "composer install"
    is_changed package-lock.json && print_notification "package-lock.json" "npm install"
    is_changed ^database/seeders && print_notification "Seeders" "php artisan db:seed"
    if is_deleted database/migrations; then
        echo -e "${YELLOW}Migration files${NC} ${RED}removed${NC}. Consider going back to the previous branch to rollback changes with ${CYAN}php artisan migrate:rollback${NC}"
    fi
    if is_modified database/migrations; then
        echo -e "${YELLOW}Migration files${NC} ${MAGENTA}modified${NC}. Consider running ${CYAN}php artisan migrate:rollback && php artisan migrate${NC}"
    fi
    if is_added database/migrations; then
        echo -e "${YELLOW}Migration files${NC} ${GREEN}added${NC}. Please run ${CYAN}php artisan migrate${NC}"
    fi
}
