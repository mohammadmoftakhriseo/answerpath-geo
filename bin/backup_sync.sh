#!/usr/bin/env bash
# ==============================================================================
# Mohammad Moftakhari CMS - GitHub Automated Backup Script (Bash Edition)
# Repository: https://github.com/mohammadmoftakhriseo/answerpath-geo
# ==============================================================================

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(dirname "$SCRIPT_DIR")"
LOG_FILE="$ROOT_DIR/storage/logs/git_backup.log"

mkdir -p "$ROOT_DIR/storage/logs"

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

log "=== Starting Shell Automated Git Backup ==="

cd "$ROOT_DIR"

if [ ! -f .env ]; then
    log "ERROR: .env file not found."
    exit 1
fi

# Extract variables from .env
GITHUB_TOKEN=$(grep -E '^GITHUB_TOKEN=' .env | cut -d '=' -f2- | tr -d '"' | tr -d "'" | tr -d '\r')
GITHUB_OWNER=$(grep -E '^GITHUB_OWNER=' .env | cut -d '=' -f2- | tr -d '"' | tr -d "'" | tr -d '\r')
GITHUB_REPO=$(grep -E '^GITHUB_REPO=' .env | cut -d '=' -f2- | tr -d '"' | tr -d "'" | tr -d '\r')
GITHUB_BRANCH=$(grep -E '^GITHUB_BRANCH=' .env | cut -d '=' -f2- | tr -d '"' | tr -d "'" | tr -d '\r')

GITHUB_OWNER=${GITHUB_OWNER:-mohammadmoftakhriseo}
GITHUB_REPO=${GITHUB_REPO:-answerpath-geo}
GITHUB_BRANCH=${GITHUB_BRANCH:-main}

if [ -z "$GITHUB_TOKEN" ] || [[ "$GITHUB_TOKEN" == your_* ]]; then
    log "SKIPPED: GITHUB_TOKEN is empty or placeholder in .env"
    exit 0
fi

if [ ! -d .git ]; then
    log "Initializing git repository..."
    git init
    git branch -M "$GITHUB_BRANCH"
fi

git config user.name "Mohammad Moftakhari (Automation)"
git config user.email "mohammad@maaadmr.ir"

REMOTE_URL="https://${GITHUB_TOKEN}@github.com/${GITHUB_OWNER}/${GITHUB_REPO}.git"

if git remote get-url origin > /dev/null 2>&1; then
    git remote set-url origin "$REMOTE_URL"
else
    git remote add origin "$REMOTE_URL"
fi

git add .

if git diff --cached --quiet; then
    log "NO CHANGES: Nothing to commit."
else
    COMMIT_MSG="Auto-backup: $(date '+%Y-%m-%d %H:%M:%S') [Server Bash Sync]"
    git commit -m "$COMMIT_MSG"
    log "Pushing to $GITHUB_OWNER/$GITHUB_REPO ($GITHUB_BRANCH)..."
    git push -u origin "$GITHUB_BRANCH"
    log "Push completed successfully."
fi

log "=== Backup Finished ==="
