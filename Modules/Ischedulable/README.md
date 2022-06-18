# imaginacms-ischedulable

Polymorphic module to relate a schedule entity

> To use, Run migrations and seeds.

## Install

```bash
composer require imagina/ischedulable-module=v8.x-dev
```

## Enable the module

```bash
php artisan module:enable Ischedulable
```

## Traits

- ## schedulable
  Synchronize schedules related to your model. Listen the Event `createdWithBindings` and `updatedWithBindings` to do
  it.
    - #### Relations
        - **schedule** `morphOne` Return all related schedule of your model.
        - **schedule.workTimes** `hasMany` Return all related schedule with their workTimes.
        - **schedule.workTimes.day** `belongsTo` Return all related schedule with their workTimes and their day.
        -
    - #### Use
      Use the `Schedulable` Trait in your entity.
      ```php
      use Modules\Ischedulable\Support\Traits\Schedulable;
    
      class YourEntityClass extends CrudModel
      {
        use Translatable, Schedulable;
      
        // Your entity code...
      }
      ```
      When you are creating or updating your entity, add the schedule data to sync it.
      > Sync: Only when the entity data has the `schedule` attribute the trait will make the sync.

      > Remove: To remove the schedule of the entity, sent in the entity data the attribute `schedule` as `false`.
      ```php
        //Entity Data
        {
        // Your entity attributes/data..
        
        // Schedule data to sync with the entity
        "schedule": {
          "zone": "main",
          "status": 1,
          "from_date" : "2021-03-08 08:00",
          "to_date" : "2021-03-08 08:00",
          "work_times": [
            {
              "day_id": 2,
              "start_hour": "2021-03-08 08:00",
              "end_hour": "2021-03-08 10:00",
              "shift_time" : "60",
            },
            {
              "day_id": 1,
              "start_hour": "2021-03-08 07:00",
              "end_hour": "2021-03-08 12:30",
              "shift_time" : "60",
            }
         ]
        }
      }
      ```

## Entities

- ## Schedule
  Save Polymorphic Schedules
    - #### Relations
        - **worktimes** `hasMany` Return all related workTime of schedule.
    - #### Methods
        - **getShifts(['dateRange','busyShifts'])** Return all shifts according to worktimes of the schedule by
          intervals of minutes.
          > To get shifts with the day model add in request the relation `workTimes.day`
            - **Parameters**
                - ***dateRange*** `Array` one array with the date range to generate the shifts, if not exist this
                  parameter will loaded the current date until 6 days in future.
                  ```php
                  //Obtain the shifts to 2021-09-01 until 2021-09-03 according to workTimes by day of the shedule model
                  $scheduleModel->getShifts(['dateRange' => ['2021-09-01', '2021-09-03']])
                  ```
                - ***busyShifts*** `Array of Arrays`  Array with the busy shift reference to validate if shift generate
                  by the method is busy or not.
                  ```php
                  $scheduleModel->getShifts([
                    'busyShifts' => [
                      ['startTime' => '06:00:00', 'endTime' => '08:22:00', 'calendarDate' => '2021-09-06'],
                      ['startTime' => '06:00:00', 'endTime' => '07:22:00', 'calendarDate' => '2021-09-02'],
                      ['startTime' => '08:00:00', 'endTime' => '09:00:00', 'calendarDate' => '2021-09-03'],
                    ]
                  ]);
                  ```
            - Response   
              Yo get shifts orderer by calendarDate, dayId and startTime on asc way
              ```php
              //You get a array of arrays with shifts on this format
              [▼
                "busyBy" => [/*busy model set on parameter busyShift*/]
                "calendarDate" => "2021-09-06"
                "day" => //Modules\Ischedulable\Entities\Day Model 
                "dayId" => 1 //Iso Day
                "endTime" => "09:00:00"
                "isBusy" => 1
                "scheduleId" => 7
                "startTime" => "08:00:00"
              ] 
              ``` 
- ## WorkTime
  Save one or many work time to schedule
    - #### Relations
        - **day** `belongsTo` Return the Day model.
        - **schedule** `belongsTo` Return the Schedule model
    - #### Methods
        - **getShifts()** Generate and return the shifts of the current worktime.
          ```php
          $workTimeModel->getShifts()
          ```
- ## Day
  Has the translatable week days with the iso number

  | Day | ISO |
    | :-----: | :----: |
  | Monday | 1 |
  | Tuesday | 2 |
  | Wednesday | 3 |
  | Thursday | 4 |
  | Friday | 5 |
  | Saturday | 6 |
  | Sunday | 7 |
