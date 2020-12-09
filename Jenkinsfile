pipeline {
    agent any
    environment {
	    BranchString =  "$params.branch" //double-quotes
	    ImageName = JOB_NAME.replaceAll('/', '-')
	    Space = "tinson"
    }
    stages {
        stage('Checkout') {
            steps {
                println BranchString
                git branch: branch.split('/')[1], credentialsId: 'tinson', url: 'git@gitee.com:tinson_ho/detect-mime-type.git'
            }
        }
        stage('Prepare')  {
            steps {
                echo 'Prepare'
                sh 'rm -rf vendor'
            }
        }
        stage('Build') {
            steps {
                echo 'Building'
                sh 'composer install'
            }
        }
        stage('Test') {
            steps {
                echo 'Testing'
                sh 'composer run test'
            }
        }
        stage('Deploy') {
            when {
              expression {
                currentBuild.result == null || currentBuild.result == 'SUCCESS'
              }
            }
            steps {
                echo 'Deploy'
                sh "docker build -t ${Space}/${ImageName}:${BUILD_ID} ."
                sh "docker login -u xxx -p xxx"
                sh "docker push ${Space}/${ImageName}:${BUILD_ID}"
            }
        }
    }
    post {
        always {
            echo "always"
        }
        failure {
            echo "failure"
        }
    }
}
