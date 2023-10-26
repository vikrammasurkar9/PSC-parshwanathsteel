pipeline
{
	agent any
	environment{
		staging_server="35.154.224.125"
	}

	stages{

		stage('deploy to remote'){
			step{
				sh 'scp ${WORKSPACE}/* root@{staging_server}:/var/www/html/parshwnath/'
			}
		}
	}
}
