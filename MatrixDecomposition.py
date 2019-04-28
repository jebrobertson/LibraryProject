#!/usr/bin/python3
import psycopg2
from scipy.linalg import svd
from numpy import diag
from numpy import zeros
from numpy import array
try:
    import numpy
except:
    print("To run package numpy is required")
    exit(0)

"""
@INPUT:
	R	: a matrix to factorize
	P	: The user matrix
	Q	: the book matrix
	K	: Number of latent features
	iterations	: number of times to optimize
	alpha	: the rate of approaching the optimal solution
	beta	: the regularization 
"""

def matrix_decomposition(R, P, Q, K, iterations=5000, alpha=.0002, beta=.02):
    for step in range(iterations):
        if step % 1000 == 0:
            print(step)
    
        error = numpy.subtract(R, numpy.matmul(P,  Q.T))
        for i in range(len(R)):
            for j in range(len(R[0])):
                if R[i][j] == 0:
                    error[i][j] = 0
        P += alpha * numpy.subtract(2 * numpy.matmul(error , Q), beta * P)
        Q += alpha * numpy.subtract(2 * numpy.matmul(error.T , P), beta * Q)
    return P, Q




    
if __name__ == "__main__":
    MAX_SIZE = 1000
    
    conn = psycopg2.connect(host="librarezdb.cbarom9u2wq0.us-east-2.rds.amazonaws.com", database="LibrarEZDB", user="librarEZAdmin",password="adminpass")
    cur = conn.cursor()
    cur.execute('SELECT COUNT(*) FROM users')
    N = cur.fetchone()[0]
    if N > MAX_SIZE:
        N = MAX_SIZE
    cur.execute('SELECT isbn FROM books')
    M = cur.rowcount
    
    if M > MAX_SIZE:
        M = MAX_SIZE
    books = []
    print("Number of books = " + str(M))
    R = numpy.zeros([N,M])
    rows = cur.fetchall()
    count = 0
    for count in range(M):
        books.append(rows[count])
        cur.execute('SELECT userid, userrating FROM ratings WHERE isbn=%s', rows[count])
        for review in cur.fetchall():
            id = review[0]
            if id > MAX_SIZE:
                continue
            rating = review[1]
            R[id][count] = rating

    print(R)
#    R = numpy.array(R)


    
    N = len(R)
    M = len(R[0])
    K = 2

    P = numpy.random.rand(N,K)
    Q = numpy.random.rand(M,K)
    print("Starting matrix decomposition")
    nP, nQ = matrix_decomposition(R, P, Q, K)
    print("Finished") 
    print(numpy.matmul(nP, nQ.T))
    print("Updating tables")
    cur.execute("TRUNCATE TABLE factoredusers")
    cur.execute("TRUNCATE TABLE factoredbooks")
    for i in range(len(P)):
        cur.execute("INSERT INTO factoredusers VALUES (%s, %s, %s)", (i, P[i][0], P[i][1]))
    conn.commit()
    for i in range(len(Q)):
        cur.execute("INSERT INTO factoredbooks VALUES (%s, %s, %s)", (rows[i], Q[i][0], Q[i][1])) 
    conn.commit()
    cur.close()
    conn.close()
