<?php

require __DIR__ . '/vendor/autoload.php';

use Maclof\Kubernetes\Client;
use Maclof\Kubernetes\Models\ReplicationController;
$client = new Client([
	'master' 		=> 'https://192.168.1.194:6443',
	'ca_cert'     	=> '/etc/kubernetes/pki/ca.crt',
    'client_cert' 	=> '/etc/kubernetes/pki/apiserver-kubelet-client.crt',
    'client_key'  	=> '/etc/kubernetes/pki/apiserver-kubelet-client.key',
]);

// Find pods by label selector
// $pods = $client->pods()->setLabelSelector([
// 	'name'    => 'test',
// 	'version' => 'a',
// ])->find();

// // Find pods by field selector
// $pods = $client->pods()->setFieldSelector([
// 	'metadata.name' => 'test',
// ])->find();

// Find first pod with label selector (same for field selector)
// $pod = $client->pods()->setLabelSelector([
// 	'app' => 'redis-operator',
// ])->find();

// $nodes = $client->nodes()->find();



$replicationController = new ReplicationController([
	'metadata' => [
		'name' => 'kali-test',
		'labels' => [
			'name' => 'kali-test',
		],
	],
	'spec' => [
		'replicas' => 1,
		'template' => [
			'metadata' => [
				'labels' => [
					'name' => 'kali-test',
				],
			],
			'spec' => [
				'containers' => [
					[
						'name'  => 'kali-vnc',
						'image' => 'dongshufeng/kali-vnc:0.1',
						'ports' => [
							[
								'containerPort' => 5901,
								'protocol'      => 'TCP',
							],
						],
					]
				],
			],
		],
	],
]);

// $replicationController = $client->replicationControllers()->setLabelSelector([
// 	'name' => 'kali-test',
// ])->first();
// $res = $client->replicationControllers()->delete($replicationController);
// var_dump($res);
// $pods = $client->pods()->setLabelSelector([
// 	'name' => 'kali-test'
// ])->first();
// $re = $client->pods()->delete($pods);
// var_dump($re);
// var_dump($res);
if ($client->replicationControllers()->exists($replicationController->getMetadata('name'))) {
	$client->replicationControllers()->update($replicationController);
} else {
	$client->replicationControllers()->create($replicationController);
}

