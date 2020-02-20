# MY TOY CARS - a simple app for little boys to enjoy their cars

## Basic forms
1. Investigate more modular form input components...
1. Improve race city select - replace list with one that contains country and show country to user
2. Change colour in create car to colour select
3. Change some other input to select and/or multi select
4. Try and incorporate a time/date inht using some vue package
5.  Add preview of car when uploading a new image to replace an existing one
6. Check all crud forms 1. work for create/edit/delete 2. validate data properly 3. show validation errors properly

## General
4. Distinguish login from splash screen
5. Set up email

## Permissions etc. 
1. Use form requests for all back end validation - need to do this for car
2. Create base controller? 
3. Integrate laravel user/roles package?
4. Permissions for acting on races - should be admin only... 

## Race results
9.  Add race results as sub element to show race
10. Order cars in race result by drag and drop - admin permissions apply
11. Add race results under each race with option to drag and drop reorder for admin
12. Add a filterable/clickable list table underneath each car showing races

##  Devops
13. Fully package for devops using docker, free ssl, github actions, k8s (not swarm) and terraform... 
14. Deploy for free on heroku

## Polish
2.  Create event when new user subscribes to email me their details
3.  Integrate images from unsplash into race view page, eg shanghai for shanghai, using api call
4.  Incorporate a reports page with a number of charts with exportable .xls/csv/tsv/pdf formats.  
5.  Have seperate read and write databases ... 
6.  Try to add other laravel packages = telescope, horizon, socialite... go mad and try and add as much complexity as possible! 
7.  convert all icons to zondicon vue components

## Resources I have used
1. Laravel
2. VueJS
3. Tailwind
4. Composer packages
5. Zondicons
6. S3
7. Freenom
8. Digital ocean
9. Photopea
10. VS code
11. Mac book pro
12. Gearhost
13. Sequel pro

# to do 

review models etc
    car
    race
    race results
    users

index view of cars and past/future races

10 - 11
create and edit cars
    display images using s3 link
    validate input and give user error info

11 - 12
races and raceResults 
    create and edit only visible to admin type user
    allow all users to see races and race results
fix laravel scout
12 - 1
Finishing touches
    populate with dummy data
    clean up
    write readme
    push to github
    deploy as live site

fix tests...

## Each database table/entity should have...

1. Migration
2. Model
3. Resource
4. Controller
5. Service
6. Test (CarsTest)
7. Policy

Create a bash script to do all the above?

Finish all basic crud views

SSL cert on live site

Fix scout search speed

Move DB to digital ocean droplet to remove lag

full calendar

form wizard (for adding a race?)

laravel cashier with stripe? just a test
