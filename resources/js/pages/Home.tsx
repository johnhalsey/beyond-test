import { useEffect, useState } from 'react';
import axios from 'axios';


type Employee = {
    id: string;
    title: string;
    forename: string;
    surname: string;
};

type HomeProps = {
    employees: Employee[];
};

type EmployeeClass = {
    'id': string,
    'name': string,
    'description': string,
    'year_group': string
}
export default function Home({ employees }: HomeProps) {

    const [employeeId, setEmployeeId] = useState<string>('');
    const [classes, setClasses] = useState<EmployeeClass []>([]);

    useEffect(() => {
        // once the employee ID is populated, get the classes
        if (employeeId != '') {
            getClassesForEmployee();
        }

    }, [employeeId]);

    function getClassesForEmployee() {
        axios.get(route('api.classes.index', { 'employeeId': employeeId }))
            .then((response) => {
                console.log(response.data)
                setClasses(response.data.data);
            })
            .catch((error) => {
                console.log('there was an error');
                console.log(error);
            });
    }

    const handleChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        setEmployeeId(e.target.value);
    };

    return (
        <>
            <div className="container mx-auto">
                <h1 className="text-2xl text-center mt-5">View My Lessons</h1>
                <div className="grid grid-cols-2 gap-2 mt-4 border p-5">
                    <label htmlFor="employee-select">Please select your name</label>
                    <select id="employee-select" className={'border p-3'} onChange={handleChange} value={employeeId}>
                        <option value="">-- Select an employee --</option>
                        {employees.map((employee: Employee) => (
                            <option key={`employee-${employee.id}`} value={employee.id}>
                                {employee.title} {employee.forename} {employee.surname}
                            </option>
                        ))}
                    </select>
                </div>

                {classes.length > 0 && classes.map((item: EmployeeClass, index) => (
                    <div className={'mt-1 border p-3 hover:bg-blue-100 cursor-pointer'}
                         key={'class-' + item.id}
                    >
                        <div>{item.name} - {item.description}</div>
                    </div>
                ))}
            </div>
        </>
    );
}
