import { useEffect, useState } from 'react';


type Employee = {
    id: string;
    title: string;
    forename: string;
    surname: string;
};

type HomeProps = {
    employees: Employee[];
};
export default function Home({employees}: HomeProps) {

    const [employeeId, setEmployeeId] = useState<string>('');

    useEffect(() => {
        // once the employee ID is populated, get the classes
    }, [employeeId]);

    const handleChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        setEmployeeId(e.target.value);
    };

    return (
        <>
            <div className="container mx-auto">
                <h1 className="text-2xl text-center mt-5">View My Lessons</h1>
                <div className="grid grid-cols-2 gap-2 mt-4">
                    <label htmlFor="employee-select">Please select your name</label>
                    <select id="employee-select" onChange={handleChange} value={employeeId}>
                        <option value="">-- Select an employee --</option>
                        {employees.map((employee:Employee) => (
                            <option key={`employee-${employee.id}`} value={employee.id}>
                                {employee.title} {employee.forename} {employee.surname}
                            </option>
                        ))}
                    </select>
                </div>
            </div>


        </>
    );
}
