pipeline
{
	agent any
	environment{
		staging_server="10.10.10.10"
	}

	stages{

		stage('deploy to remote'){
			step{
				sh 'scp ${WORKSPACE}/* root@{staging_server}:/var/www/html/parshwnath/'
			}
		}
	}
}
