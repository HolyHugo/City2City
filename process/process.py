#!/usr/bin/python3
# coding: utf-8

import os
import csv
import sys
import googlemaps
import pandas as pd

api_key = sys.argv[1]
separator_entry = sys.argv[2]
separator_output = sys.argv[3]
filename = sys.argv[4]
gmaps = googlemaps.Client(key=api_key)
lines = []
origins = []
destinations = []
absolute_path = os.path.dirname(os.path.abspath(__file__))

with open(absolute_path+"/inputfile.csv", "r") as f:

    reader = csv.reader(f, delimiter=separator_entry)
    for i, line in enumerate(reader):
        origins.insert(0,line[0])
        destinations.insert(0,line[1]);
        matrix = gmaps.distance_matrix(origins, destinations)
        distance = '/'
        if 'distance' in matrix['rows'][0]['elements'][0]:
	        distance = matrix['rows'][0]['elements'][0]['distance']['text']
	   
        line = [matrix['origin_addresses'][0] , matrix['destination_addresses'][0] , distance, '---',origins[0],destinations[0]]
        lines.append(line)


absolute_path = os.path.dirname(os.path.abspath(__file__))
with open(absolute_path+"/done/done.csv", 'w') as target:
  writer = csv.writer(target,delimiter=separator_output)
  writer.writerow(['Ville départ','Ville arrivée','Distance', '---','Ville départ origine','Ville destination origine '])
  writer.writerows(lines)

os.rename(absolute_path+'/done/done.csv',absolute_path+'/available/'+filename+'.csv')


