#!/usr/bin/env bash
if [[ ! -a 'amsProxy.db' ]]; then
  cat amsProxy.sql | sqlite3 amsProxy.db
fi
