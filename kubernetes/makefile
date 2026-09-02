namespace:
	kubectl apply -f namespace.yaml

phpfpm:
	kubectl apply -f phpfpm-deployment.yaml
	kubectl apply -f phpfpm-service.yaml

postgres:
	kubectl apply -f  postgres-deployment.yaml
	kubectl apply -f postgres-service.yaml

httpd:
	 kubectl apply -f httpd-deployment.yaml
	 kubectl apply -f httpd-service.yaml

create:
	kubectl apply -f namespace.yaml
	kubectl apply -f metrics-server.yaml
	kubectl apply -f secrets.yaml
	kubectl apply -f postgres-deployment.yaml
	kubectl apply -f postgres-service.yaml
	kubectl apply -f postgres-hpa.yaml
	kubectl apply -f phpfpm-deployment.yaml
	kubectl apply -f phpfpm-service.yaml
	kubectl apply -f phpfpm-hpa.yaml
	kubectl apply -f httpd-deployment.yaml
	kubectl apply -f httpd-service.yaml
	kubectl apply -f httpd-hpa.yaml
	kubectl config set-context --current --namespace=bookcatalogapp

delete:
	kubectl delete deployment httpd-deploy phpfpm-depoly postgres-depoly
	kubectl delete service httpd-service phpfpm-service postgres-service 
	kubectl delete hpa httpd-deploy-hpa 
	kubectl delete hpa phpfpm-deploy-hpa 
	kubectl delete hpa postgres-deploy-hpa
	kubectl delete secrets app-secrets
	





