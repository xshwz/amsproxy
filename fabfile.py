from fabric.api import run, env, task, local, put, cd, sudo
from datetime import datetime

# env.host_string = 'xsh.gxun.edu.cn:443'

now = datetime.now().strftime('%Y-%m-%d.%H-%M-%S')

_source_list = [
  'extensions/',
  'libs/AmsProxy/',
  'models/',
  'modules/',
  'public/',
]

_source_vendor_list = [
  'libs/Requests/',
  'libs/SimplePie/',
  'libs/yii/',
]

def _create_source():
  local('7z a amsproxy.7z ' + ' '.join(_source_list))

def _create_vendor():
  local('7z a vendor.7z ' + ' '.join(_source_vendor_list))


@task
def backup_db():
  with cd('/var/www/AmsProxy'):
    run('scp data/amsProxy.db 210.36.79.100:/var/xsh_backups/amsproxy/amsProxy.' + now + '.db')

@task(default=True)
def deploy():
  _create_source()
  with cd('/var/www/AmsProxy'):
    run('rm -rf ' + ' '.join(_source_list))
    put('amsproxy.7z', 'amsproxy.7z')
    run('7z x amsproxy.7z')
    run('rm amsproxy.7z')
  local('rm amsproxy.7z')

@task
def deploy_vendor():
  _create_vendor()
  with cd('/var/www/AmsProxy'):
    run('rm -rf ' + ' '.join(_source_vendor_list))
    put('vendor.7z', 'vendor.7z')
    run('7z x vendor.7z')
    run('rm vendor.7z')
  local('rm vendor.7z')
