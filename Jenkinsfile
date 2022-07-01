pipeline {

  agent any

  stages {
  stage('build') {
    steps {
      echo 'Building'
    }
  }

  stage('test') {
    steps {
        sh './vendor/bin/phpunit --log-junit test.xml -c phpunit.xml'
    }
  }

  stage('deploy') {
    steps {
        echo 'Deploying ...'
        echo 'Done'
    }
  }
 }
}