 let sum_up_recursive = (numbers, target, partial = [], executed = 0, exec_history = [])=>{
        executed++;
        $scope.count ++;


        exec_history =exec_history.slice(0);

        //console.log($scope.count + '/' + Math.pow(2, $scope.numbersAdded.length));


        let s= 0;

        partial.forEach(x=>{s += x});

        if(partial.length > 0)
            console.log(partial[0]);

       
        s= Number.parseFloat(s).toFixed(2);
        target = Number.parseFloat(target).toFixed(2);

        //console.log(s, target);

        if(Math.abs(s - target)  <= $scope.max_variance_allowed){
            console.log("FOUND SOME MATCHES");
            $scope.used =  partial;
            return;
        }

        //console.log(`${s} >= ${target}`,s >= target);


        exec_history.push({
            exec : executed,
            value : numbers[0],
        })

        //console.log(exec_history);
        //console.log( numbers, partial);

        for (let i = 0; i < numbers.length; i++)
        {
            if($scope.used && $scope.used.length != 0) break;

            let remaining = [];
            let n = numbers[i];

            for (let j = i + 1; j < numbers.length; j++) {
                remaining.push(numbers[j]);
            }

            let partial_rec = partial.slice(0);
            partial_rec.push(n);

            s = 0;
            partial_rec.forEach(x=>{s += x});
            s = Math.round(s);
            t = Math.round(target);

            if(s > t && $scope.fastMode) {
                continue;
            }
            
            sum_up_recursive(remaining, target, partial_rec, executed, exec_history);
        }
    }